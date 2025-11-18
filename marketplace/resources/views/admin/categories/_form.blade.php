@php($isEdit = isset($category))
<label class="text-sm font-semibold text-gray-700">
    Ad
    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Slug
    <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Üst Kategori
    <select name="parent_id" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
        <option value="">Yok</option>
        @foreach($parents as $id => $name)
            <option value="{{ $id }}" @selected(old('parent_id', $category->parent_id ?? '') == $id)>{{ $name }}</option>
        @endforeach
    </select>
</label>
<label class="flex items-center gap-2 text-sm text-gray-600">
    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $category->is_active ?? true))>
    Aktif
</label>
