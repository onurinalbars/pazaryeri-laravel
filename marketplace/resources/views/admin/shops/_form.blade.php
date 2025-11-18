@php($isEdit = isset($shop))
<label class="text-sm font-semibold text-gray-700">
    Vendor
    <select name="user_id" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
        @foreach($vendors as $id => $name)
            <option value="{{ $id }}" @selected(old('user_id', $shop->user_id ?? '') == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>
<label class="text-sm font-semibold text-gray-700">
    Mağaza Adı
    <input type="text" name="name" value="{{ old('name', $shop->name ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Slug
    <input type="text" name="slug" value="{{ old('slug', $shop->slug ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Açıklama
    <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('description', $shop->description ?? '') }}</textarea>
</label>
<label class="text-sm font-semibold text-gray-700">
    Logo
    <input type="file" name="logo" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="flex items-center gap-2 text-sm text-gray-600">
    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $shop->is_active ?? false))>
    Aktif
</label>
