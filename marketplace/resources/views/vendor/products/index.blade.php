@extends('layouts.vendor')

@section('page-title', 'Ürünlerim')

@section('content')
    <div class="flex items-center justify-between rounded-2xl bg-white p-5 shadow">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Ürünler</h1>
            <p class="text-sm text-gray-500">Mağazanızdaki tüm ürünler</p>
        </div>
        <a href="{{ route('vendor.products.create') }}" class="rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Yeni Ürün</a>
    </div>

    <div class="mt-6 space-y-4">
        @foreach($products as $product)
            <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ $product->name }}</p>
                    <p class="text-sm text-gray-500">Fiyat: {{ number_format($product->price, 2) }} ₺</p>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('vendor.products.edit', $product) }}" class="rounded-full border border-gray-300 px-4 py-1 text-gray-700 hover:border-emerald-400 hover:text-emerald-600">Düzenle</a>
                    <form method="POST" action="{{ route('vendor.products.destroy', $product) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-red-200 px-4 py-1 text-red-600 hover:bg-red-50">Sil</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection
