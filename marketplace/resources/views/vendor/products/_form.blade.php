@php($isEdit = isset($product))
<label class="text-sm font-semibold text-gray-700">
    Ürün Adı
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Kategori
    <select name="category_id" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
        <option value="">Seçiniz</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $product->category_id ?? '') == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>
<label class="text-sm font-semibold text-gray-700">
    Açıklama
    <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
</label>
<div class="grid gap-4 md:grid-cols-2">
    <label class="text-sm font-semibold text-gray-700">
        Fiyat
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
    </label>
    <label class="text-sm font-semibold text-gray-700">
        Stok
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
    </label>
</div>
<label class="text-sm font-semibold text-gray-700">
    Görsel
    <input type="file" name="image" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="flex items-center gap-2 text-sm text-gray-600">
    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $product->is_active ?? true))>
    Yayında
</label>
