<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()->shop
            ->products()
            ->with(['category', 'primaryImage'])
            ->withCount(['variants', 'images'])
            ->latest()
            ->paginate(15);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request)
    {
        $shop = $request->user()->shop;
        $validated = $request->validate($this->rules());

        $productData = collect($validated)->only([
            'name',
            'category_id',
            'description',
            'price',
            'stock',
        ])->toArray();

        $productData['shop_id'] = $shop->id;
        $productData['is_active'] = $request->boolean('is_active');

        $product = DB::transaction(function () use ($productData, $request, $validated) {
            $product = Product::create($productData);

            $this->syncVariants($product, $validated['variants'] ?? []);
            $this->syncImages($product, $request, $validated['remove_image_ids'] ?? [], $validated['primary_image_id'] ?? null);

            return $product;
        });

        return redirect()
            ->route('vendor.products.index')
            ->with('success', "{$product->name} created.");
    }

    public function edit(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $product->load(['images' => fn ($query) => $query->orderBy('sort_order'), 'variants']);

        return view('vendor.products.edit', [
            'product' => $product,
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $validated = $request->validate($this->rules($product));

        $productData = collect($validated)->only([
            'name',
            'category_id',
            'description',
            'price',
            'stock',
        ])->toArray();
        $productData['is_active'] = $request->boolean('is_active');

        DB::transaction(function () use ($product, $productData, $request, $validated) {
            $product->update($productData);

            $this->syncVariants($product, $validated['variants'] ?? []);
            $this->syncImages($product, $request, $validated['remove_image_ids'] ?? [], $validated['primary_image_id'] ?? null);
        });

        return redirect()
            ->route('vendor.products.index')
            ->with('success', "{$product->name} updated.");
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        DB::transaction(function () use ($product) {
            $product->variants()->delete();

            $product->images->each(function ($image) {
                if ($image->path) {
                    Storage::disk('public')->delete($image->path);
                }
            });

            $product->images()->delete();

            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();
        });

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product removed.');
    }

    protected function authorizeProduct(Request $request, Product $product): void
    {
        abort_if($product->shop_id !== $request->user()->shop->id, 403);
    }

    protected function categories()
    {
        return Category::where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id');
    }

    protected function rules(?Product $product = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'remove_image_ids' => ['sometimes', 'array'],
            'remove_image_ids.*' => ['integer'],
            'primary_image_id' => ['nullable', 'integer'],
            'variants' => ['nullable', 'array'],
            'variants.*.id' => ['nullable', 'integer'],
            'variants.*.name' => ['nullable', 'string', 'max:120'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.sku' => ['nullable', 'string', 'max:120'],
        ];
    }

    protected function syncImages(Product $product, Request $request, array $removeImageIds, ?int $primaryImageId): void
    {
        if ($removeImageIds) {
            $imagesToRemove = $product->images()
                ->whereIn('id', $removeImageIds)
                ->get();

            foreach ($imagesToRemove as $image) {
                if ($image->path) {
                    Storage::disk('public')->delete($image->path);
                }

                $image->delete();
            }
        }

        $sortOrder = (int) ($product->images()->max('sort_order') ?? 0);
        $newImages = collect();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                if (! $imageFile) {
                    continue;
                }

                $path = $imageFile->store('products/gallery', 'public');

                $newImages->push(
                    $product->images()->create([
                        'path' => $path,
                        'sort_order' => ++$sortOrder,
                        'is_primary' => false,
                    ])
                );
            }
        }

        $primaryImage = $primaryImageId
            ? $product->images()->whereKey($primaryImageId)->first()
            : null;

        if (! $primaryImage && $newImages->isNotEmpty()) {
            $primaryImage = $newImages->first();
        }

        if ($primaryImage) {
            $product->images()
                ->where('id', '!=', $primaryImage->id)
                ->update(['is_primary' => false]);

            $primaryImage->update(['is_primary' => true]);
            $product->update(['image_path' => $primaryImage->path]);
        } elseif (! $product->image_path) {
            $fallback = $product->images()->oldest('sort_order')->first();

            if ($fallback) {
                $fallback->update(['is_primary' => true]);
                $product->update(['image_path' => $fallback->path]);
            } elseif (! $product->images()->exists()) {
                $product->update(['image_path' => null]);
            }
        } elseif (! $product->images()->exists()) {
            $product->update(['image_path' => null]);
        }
    }

    protected function syncVariants(Product $product, ?array $variants): void
    {
        $variantIds = [];
        $variantsCollection = collect($variants ?? []);

        foreach ($variantsCollection as $variant) {
            $name = trim($variant['name'] ?? '');

            if ($name === '') {
                continue;
            }

            $payload = [
                'name' => $name,
                'price' => $variant['price'] !== null ? (float) $variant['price'] : null,
                'stock' => isset($variant['stock']) ? (int) $variant['stock'] : 0,
                'sku' => $variant['sku'] ?? null,
            ];

            if (! empty($variant['id'])) {
                $existing = $product->variants()->whereKey($variant['id'])->first();

                if ($existing) {
                    $existing->update($payload);
                    $variantIds[] = $existing->id;
                }
            } else {
                $variantIds[] = $product->variants()->create($payload)->id;
            }
        }

        if ($variantIds) {
            $product->variants()->whereNotIn('id', $variantIds)->delete();
        } else {
            $product->variants()->delete();
        }
    }
}