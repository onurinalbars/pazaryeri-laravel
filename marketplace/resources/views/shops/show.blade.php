@extends('layouts.app')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $shop->name }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $shop->description }}</p>
            </div>
            <div class="text-sm text-gray-500">
                Aktif Durum: <span class="font-semibold {{ $shop->is_active ? 'text-emerald-600' : 'text-red-500' }}">{{ $shop->is_active ? 'Aktif' : 'Pasif' }}</span>
            </div>
        </div>
    </div>

    <section class="mt-8 space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">Ürünler</h2>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($products as $product)
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow">
                    <div class="h-40 rounded-xl bg-gray-100">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full rounded-xl object-cover">
                        @endif
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-lg font-semibold text-gray-800 hover:text-emerald-600">{{ $product->name }}</a>
                        <p class="text-lg font-bold text-emerald-600">{{ number_format($product->price, 2) }} ₺</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </section>

    <section class="mt-12 space-y-4">
        <h2 class="text-xl font-semibold text-gray-800">İlanlar</h2>
        <div class="grid gap-4 md:grid-cols-2">
            @foreach($listings as $listing)
                <a href="{{ route('listings.show', $listing->slug) }}" class="rounded-2xl border border-gray-200 bg-white p-4 shadow hover:border-emerald-500">
                    <p class="text-lg font-semibold text-gray-800">{{ $listing->title }}</p>
                    <p class="text-sm text-gray-500">{{ $listing->location }}</p>
                    @if($listing->price)
                        <p class="text-sm font-semibold text-emerald-600">{{ number_format($listing->price, 2) }} ₺</p>
                    @endif
                </a>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $listings->links() }}
        </div>
    </section>
@endsection
