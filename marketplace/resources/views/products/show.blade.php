@extends('layouts.app')

@section('content')
    <div class="grid gap-8 md:grid-cols-3">
        <div class="md:col-span-2 space-y-6 rounded-2xl bg-white p-6 shadow">
            <div class="h-96 rounded-2xl bg-gray-100">
                @if($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full rounded-2xl object-cover">
                @endif
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $product->shop->name }}</p>
                <p class="mt-4 text-lg text-gray-700">{{ $product->description }}</p>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow">
                <p class="text-3xl font-bold text-emerald-600">{{ number_format($product->price, 2) }} ₺</p>
                <p class="mt-2 text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-4 space-y-3">
                    @csrf
                    <label class="text-sm font-medium text-gray-700">
                        Adet
                        <input type="number" min="1" max="{{ $product->stock }}" name="quantity" value="1" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Sepete Ekle</button>
                </form>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow">
                <h3 class="text-lg font-semibold text-gray-800">Mağaza Bilgisi</h3>
                <p class="mt-2 text-sm text-gray-600">{{ $product->shop->name }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ Str::limit($product->shop->description, 120) }}</p>
                <a href="{{ route('shops.show', $product->shop->slug) }}" class="mt-4 inline-flex items-center text-sm font-semibold text-emerald-600 hover:underline">Mağazayı Gör</a>
            </div>
        </div>
    </div>

    @if($relatedProducts->count())
        <div class="mt-12">
            <h2 class="mb-4 text-xl font-semibold text-gray-800">Benzer Ürünler</h2>
            <div class="grid gap-6 md:grid-cols-4">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="rounded-2xl border border-gray-200 bg-white p-4 shadow hover:border-emerald-500">
                        <div class="h-32 rounded-xl bg-gray-100">
                            @if($related->image_path)
                                <img src="{{ Storage::url($related->image_path) }}" alt="{{ $related->name }}" class="h-full w-full rounded-xl object-cover">
                            @endif
                        </div>
                        <p class="mt-3 font-semibold text-gray-800">{{ $related->name }}</p>
                        <p class="text-sm text-gray-500">{{ $related->shop->name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection
