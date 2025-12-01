@php
    $isEdit = isset($product);
    $currentVariants = collect(old('variants', $isEdit
        ? $product->variants->map(fn ($variant) => [
            'id' => $variant->id,
            'name' => $variant->name,
            'price' => $variant->price,
            'stock' => $variant->stock,
            'sku' => $variant->sku,
        ])
        : []
    ))->values();

    if ($currentVariants->isEmpty()) {
        $currentVariants = collect([['id' => null, 'name' => '', 'price' => '', 'stock' => '', 'sku' => '']]);
    }

    $primaryImageId = old('primary_image_id', $isEdit ? $product->images->firstWhere('is_primary', true)?->id : null);
@endphp

<div class="space-y-8">
    <div class="grid gap-6 lg:grid-cols-2">
        <label class="text-sm font-semibold text-gray-700">
            Product name
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
        </label>

        <label class="text-sm font-semibold text-gray-700">
            Category
            <select name="category_id" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                <option value="">Select category</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" @selected(old('category_id', $product->category_id ?? '') == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-sm font-semibold text-gray-700">
            Price (₺)
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
        </label>

        <label class="text-sm font-semibold text-gray-700">
            Stock (default SKU)
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
        </label>
    </div>

    <label class="block text-sm font-semibold text-gray-700">
        Description
        <textarea name="description" rows="5" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $product->description ?? '') }}</textarea>
    </label>

    <div>
        <h3 class="text-base font-semibold text-gray-900">Media gallery</h3>
        <p class="text-sm text-gray-500">Upload multiple product images. Set a primary cover image for listings.</p>
        <div class="mt-4 space-y-3">
            <label class="text-sm font-semibold text-gray-700">
                Upload images
                <input type="file" name="images[]" multiple class="mt-1 w-full rounded-lg border border-dashed border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                <span class="mt-1 block text-xs text-gray-400">You can select several files at once. Accepted types: JPG, PNG, WEBP (max 4MB each).</span>
            </label>

            @if($isEdit && $product->images->isNotEmpty())
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach($product->images as $image)
                        <div class="rounded-xl border border-gray-200 p-3">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}" alt="Product image" class="h-40 w-full rounded-lg object-cover">
                            <div class="mt-3 flex items-center justify-between text-xs text-gray-600">
                                <label class="flex items-center gap-1">
                                    <input type="radio" name="primary_image_id" value="{{ $image->id }}" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" @checked($primaryImageId == $image->id)>
                                    Primary
                                </label>
                                <label class="flex items-center gap-1 text-red-600">
                                    <input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}" class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                    Remove
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-gray-900">Variants</h3>
                <p class="text-sm text-gray-500">Use variants to add different sizes, colors, or bundles. Leave blank to skip.</p>
            </div>
            <button type="button" id="addVariantRow" class="rounded-full border border-gray-300 px-3 py-1 text-xs font-semibold text-gray-700 hover:border-emerald-400 hover:text-emerald-600">Add variant</button>
        </div>
        <div id="variantRows" class="mt-4 space-y-3">
            @foreach($currentVariants as $index => $variant)
                <div class="variant-row rounded-xl border border-gray-200 p-4" data-row="{{ $index }}">
                    <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Name</label>
                            <input type="text" name="variants[{{ $index }}][name]" value="{{ $variant['name'] ?? '' }}" placeholder="e.g. Large / Red" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant['id'] ?? '' }}">
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Price override</label>
                            <input type="number" step="0.01" name="variants[{{ $index }}][price]" value="{{ $variant['price'] ?? '' }}" placeholder="Leave empty to inherit" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Stock</label>
                            <input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant['stock'] ?? '' }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">SKU</label>
                            <input type="text" name="variants[{{ $index }}][sku]" value="{{ $variant['sku'] ?? '' }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                    <button type="button" class="remove-variant mt-3 text-xs font-semibold text-red-600 hover:underline">Remove</button>
                </div>
            @endforeach
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm font-semibold text-gray-600">
        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" @checked(old('is_active', $product->is_active ?? true))>
        This product is active and visible
    </label>
</div>

@push('scripts')
    @once
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.getElementById('variantRows');
                const addButton = document.getElementById('addVariantRow');

                if (!container || !addButton) return;

                const template = (index) => `
                    <div class="variant-row rounded-xl border border-gray-200 p-4" data-row="${index}">
                        <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Name</label>
                                <input type="text" name="variants[${index}][name]" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500" placeholder="e.g. Small / Blue">
                                <input type="hidden" name="variants[${index}][id]" value="">
                            </div>
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Price override</label>
                                <input type="number" step="0.01" name="variants[${index}][price]" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Leave empty to inherit">
                            </div>
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Stock</label>
                                <input type="number" name="variants[${index}][stock]" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">SKU</label>
                                <input type="text" name="variants[${index}][sku]" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>
                        <button type="button" class="remove-variant mt-3 text-xs font-semibold text-red-600 hover:underline">Remove</button>
                    </div>
                `;

                const syncRemoveButtons = () => {
                    container.querySelectorAll('.remove-variant').forEach((button) => {
                        button.onclick = () => {
                            const row = button.closest('.variant-row');
                            if (!row) return;

                            if (container.querySelectorAll('.variant-row').length === 1) {
                                row.querySelectorAll('input').forEach((input) => input.value = '');
                                return;
                            }

                            row.remove();
                        };
                    });
                };

                addButton.addEventListener('click', () => {
                    const nextIndex = container.querySelectorAll('.variant-row').length + Date.now();
                    container.insertAdjacentHTML('beforeend', template(nextIndex));
                    syncRemoveButtons();
                });

                syncRemoveButtons();
            });
        </script>
    @endonce
@endpush
