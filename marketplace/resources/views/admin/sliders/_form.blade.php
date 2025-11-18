<label class="text-sm font-semibold text-gray-700">
    Başlık
    <input type="text" name="title" value="{{ old('title', $slider->title ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Alt Başlık
    <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle ?? '') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Link
    <input type="url" name="link_url" value="{{ old('link_url', $slider->link_url ?? '') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<div class="grid gap-4 md:grid-cols-2">
    <label class="text-sm font-semibold text-gray-700">
        Sıra
        <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order ?? 0) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
    </label>
    <label class="flex items-center gap-2 text-sm text-gray-600">
        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $slider->is_active ?? true))>
        Aktif
    </label>
</div>
<label class="text-sm font-semibold text-gray-700">
    Görsel
    <input type="file" name="image" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
