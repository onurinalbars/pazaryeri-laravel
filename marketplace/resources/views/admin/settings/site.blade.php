@extends('admin.layout')

@section('page-title', 'Site Ayarları')
@section('page-description', 'Başlık, logo ve meta bilgilerini güncelleyin.')

@section('admin-content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.settings.site.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <label class="text-sm font-semibold text-gray-700">
                    Site Başlığı
                    <input type="text" name="title" value="{{ old('title', $site['title']) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>

                <label class="text-sm font-semibold text-gray-700">
                    Meta Açıklaması
                    <textarea name="meta_description" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="Kısa açıklama">{{ old('meta_description', $site['meta_description']) }}</textarea>
                </label>

                <label class="text-sm font-semibold text-gray-700">
                    Meta Anahtar Kelimeleri
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $site['meta_keywords']) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="ör. marketplace, alışveriş">
                </label>

                <label class="text-sm font-semibold text-gray-700">
                    Logo
                    <input type="file" name="logo" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>

                <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
                    Kaydet
                </button>
            </form>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 text-sm text-gray-600 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900">Canlı Önizleme</h3>
            @if(! empty($site['logo_path']))
                <img src="{{ asset('storage/' . $site['logo_path']) }}" alt="Logo" class="mt-4 h-20 w-20 rounded-full object-cover">
            @endif
            <p class="mt-4 text-sm text-gray-600">
                Site adı: <span class="font-semibold text-gray-900">{{ $site['title'] }}</span>
            </p>
            <p class="mt-2 text-xs uppercase tracking-widest text-gray-400">Meta Açıklaması</p>
            <p class="text-sm text-gray-600">{{ $site['meta_description'] ?: 'Henüz tanımlı değil' }}</p>
            <p class="mt-2 text-xs uppercase tracking-widest text-gray-400">Anahtar Kelimeler</p>
            <p class="text-sm text-gray-600">{{ $site['meta_keywords'] ?: 'Henüz tanımlı değil' }}</p>
        </div>
    </div>
@endsection
