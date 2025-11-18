<label class="text-sm font-semibold text-gray-700">
    Başlık
    <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Link
    <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url ?? '') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Pozisyon
    <input type="text" name="position" value="{{ old('position', $banner->position ?? 'home') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="text-sm font-semibold text-gray-700">
    Görsel
    <input type="file" name="image" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
</label>
<label class="flex items-center gap-2 text-sm text-gray-600">
    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $banner->is_active ?? true))>
    Aktif
</label>
