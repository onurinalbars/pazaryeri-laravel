@extends('layouts.vendor')

@section('page-title', 'Mağaza Ayarları')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Mağaza Bilgileri</h1>
        <form method="POST" action="{{ route('vendor.shop.update') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            <label class="text-sm font-semibold text-gray-700">
                Mağaza Adı
                <input type="text" name="name" value="{{ old('name', $shop->name) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="text-sm font-semibold text-gray-700">
                Slug
                <input type="text" name="slug" value="{{ old('slug', $shop->slug) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="text-sm font-semibold text-gray-700">
                Açıklama
                <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('description', $shop->description) }}</textarea>
            </label>
            <label class="text-sm font-semibold text-gray-700">
                Logo
                <input type="file" name="logo" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $shop->is_active))>
                Yayında
            </label>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Kaydet</button>
        </form>
    </div>
@endsection
