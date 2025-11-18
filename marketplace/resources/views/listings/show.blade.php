@extends('layouts.app')

@section('content')
    <div class="grid gap-8 md:grid-cols-3">
        <div class="md:col-span-2 space-y-6 rounded-2xl bg-white p-6 shadow">
            <div class="h-96 rounded-2xl bg-gray-100">
                @if($listing->image_path)
                    <img src="{{ Storage::url($listing->image_path) }}" alt="{{ $listing->title }}" class="h-full w-full rounded-2xl object-cover">
                @endif
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $listing->title }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $listing->location }}</p>
                <p class="mt-4 text-lg text-gray-700 whitespace-pre-line">{{ $listing->description }}</p>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow">
                @if($listing->price)
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($listing->price, 2) }} ₺</p>
                @endif
                <p class="mt-2 text-sm text-gray-500">Yayınlayan: {{ $listing->owner->name }}</p>
                <p class="mt-2 text-sm text-gray-500">Kategori: {{ $listing->category?->name }}</p>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow">
                <h3 class="text-lg font-semibold text-gray-800">Mağaza</h3>
                <p class="mt-2 text-sm text-gray-600">{{ $listing->shop->name ?? 'Mağaza Yok' }}</p>
                @if($listing->shop)
                    <a href="{{ route('shops.show', $listing->shop->slug) }}" class="mt-4 inline-flex items-center text-sm font-semibold text-emerald-600 hover:underline">Mağazayı Gör</a>
                @endif
            </div>
        </div>
    </div>

    @if($relatedListings->count())
        <div class="mt-12">
            <h2 class="mb-4 text-xl font-semibold text-gray-800">Benzer İlanlar</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($relatedListings as $related)
                    <a href="{{ route('listings.show', $related->slug) }}" class="rounded-2xl border border-gray-200 bg-white p-4 shadow hover:border-emerald-500">
                        <p class="text-lg font-semibold text-gray-800">{{ $related->title }}</p>
                        <p class="text-sm text-gray-500">{{ $related->location }}</p>
                        @if($related->price)
                            <p class="text-sm font-semibold text-emerald-600">{{ number_format($related->price, 2) }} ₺</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection
