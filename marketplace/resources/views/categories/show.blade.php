@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        <div class="rounded-2xl bg-white p-6 shadow">
            <h1 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h1>
            @if($category->children->count())
                <div class="mt-4 flex flex-wrap gap-3">
                    @foreach($category->children as $child)
                        <a href="{{ route('categories.show', $child->slug) }}" class="rounded-full border border-gray-200 px-4 py-1 text-sm text-gray-600 hover:border-emerald-500 hover:text-emerald-600">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <section>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Ürünler</h2>
            </div>
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
                            <p class="text-sm text-gray-500">{{ $product->shop->name }}</p>
                            <p class="text-lg font-bold text-emerald-600">{{ number_format($product->price, 2) }} ₺</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </section>

        <section>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">İlanlar</h2>
            </div>
            <div class="space-y-4">
                @foreach($listings as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow md:flex-row">
                        <div class="h-28 w-full flex-shrink-0 rounded-xl bg-gray-100 md:w-48">
                            @if($listing->image_path)
                                <img src="{{ Storage::url($listing->image_path) }}" alt="{{ $listing->title }}" class="h-full w-full rounded-xl object-cover">
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $listing->location }}</p>
                            @if($listing->price)
                                <p class="text-lg font-bold text-emerald-600">{{ number_format($listing->price, 2) }} ₺</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        </section>
    </div>
@endsection
