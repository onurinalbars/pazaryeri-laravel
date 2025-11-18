<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()->shop
            ->products()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->pluck('name', 'id');

        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $shop = $request->user()->shop;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['shop_id'] = $shop->id;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('vendor.products.index')->with('success', 'Product created.');
    }

    public function edit(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $categories = Category::where('is_active', true)->pluck('name', 'id');

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeProduct($request, $product);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', 'Product removed.');
    }

    protected function authorizeProduct(Request $request, Product $product): void
    {
        abort_if($product->shop_id !== $request->user()->shop->id, 403);
    }
}