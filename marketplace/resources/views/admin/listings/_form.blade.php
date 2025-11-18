<div class="grid gap-4 md:grid-cols-2">
    <label class="text-sm font-semibold text-gray-700">
        Kullanıcı
        <select name="user_id" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            @foreach($users as $id => $name)
                <option value="{{ $id }}" @selected(old('user_id', $listing->user_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm font-semibold text-gray-700">
        Mağaza
        <select name="shop_id" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            <option value="">Seçiniz</option>
            @foreach($shops as $id => $name)
                <option value="{{ $id }}" @selected(old('shop_id', $listing->shop_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </label>
</div>
<label class="text-sm font-semibold text-gray-700">
    Başlık
    <input type="text" name="title" value="{{ old('title', $listing->title ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Kategori
    <select name="category_id" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
        <option value="">Seçiniz</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" @selected(old('category_id', $listing->category_id ?? '') == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>
<label class="text-sm font-semibold text-gray-700">
    Açıklama
    <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" required>{{ old('description', $listing->description ?? '') }}</textarea>
</label>
<div class="grid gap-4 md:grid-cols-2">
    <label class="text-sm font-semibold text-gray-700">
        Fiyat
        <input type="number" step="0.01" name="price" value="{{ old('price', $listing->price ?? '') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
    </label>
    <label class="text-sm font-semibold text-gray-700">
        Lokasyon
        <input type="text" name="location" value="{{ old('location', $listing->location ?? '') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
    </label>
</div>
<label class="text-sm font-semibold text-gray-700">
    Görsel
    <input type="file" name="image" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="flex items-center gap-2 text-sm text-gray-600">
    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $listing->is_active ?? true))>
    Aktif
</label>
