@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        @if($sliders->count())
            <div class="grid gap-4 md:grid-cols-3">
                <div class="md:col-span-2 overflow-hidden rounded-2xl bg-gray-900 text-white">
                    <div class="p-10">
                        <p class="text-sm uppercase tracking-wide text-emerald-300">Öne Çıkan</p>
                        <h2 class="mt-2 text-4xl font-bold">{{ $sliders->first()->title }}</h2>
                        <p class="mt-4 max-w-xl text-gray-200">{{ $sliders->first()->subtitle }}</p>
                        @if($sliders->first()->link_url)
                            <a href="{{ $sliders->first()->link_url }}" class="mt-6 inline-flex items-center rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-emerald-600">
                                Daha Fazla
                            </a>
                        @endif
                    </div>
                </div>
                <div class="space-y-4">
                    @foreach($banners->get('home_top', collect())->take(2) as $banner)
                        <a href="{{ $banner->link_url ?? '#' }}" class="block rounded-xl border border-emerald-100 bg-white p-4 shadow hover:border-emerald-300">
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">{{ $banner->position }}</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $banner->title }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($categories->count())
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Popüler Kategoriler</h2>
                </div>
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="min-w-[140px] rounded-xl border border-gray-200 bg-white px-4 py-3 text-center hover:border-emerald-500">
                            <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                            <p class="text-xs text-gray-500">{{ $category->children->count() }} alt kategori</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Yeni Ürünler</h2>
                <a href="{{ route('cart.index') }}" class="text-sm text-emerald-600 hover:underline">Sepetim</a>
            </div>
            <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4">
                @forelse($latestProducts as $product)
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow">
                        <div class="h-40 rounded-xl bg-gray-100">
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full rounded-xl object-cover">
                            @endif
                        </div>
                        <div class="mt-4 space-y-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="block text-lg font-semibold text-gray-800 hover:text-emerald-600">{{ $product->name }}</a>
                            <p class="text-sm text-gray-500">{{ $product->shop->name }}</p>
                            <p class="text-xl font-bold text-emerald-600">{{ number_format($product->price, 2) }} ₺</p>
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Sepete Ekle</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Şu anda ürün bulunamadı.</p>
                @endforelse
            </div>
        </section>

        <section>
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Son İlanlar</h2>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                @forelse($latestListings as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow hover:border-emerald-500">
                        <div class="h-20 w-20 flex-shrink-0 rounded-xl bg-gray-100">
                            @if($listing->image_path)
                                <img src="{{ Storage::url($listing->image_path) }}" alt="{{ $listing->title }}" class="h-full w-full rounded-xl object-cover">
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $listing->location }}</p>
                            @if($listing->price)
                                <p class="text-base font-bold text-emerald-600">{{ number_format($listing->price, 2) }} ₺</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500">Henüz ilan bulunamadı.</p>
                @endforelse
            </div>
        </section>

        @if($featuredShops->count())
            <section>
                <h2 class="mb-4 text-xl font-semibold text-gray-800">Öne Çıkan Mağazalar</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($featuredShops as $shop)
                        <a href="{{ route('shops.show', $shop->slug) }}" class="rounded-2xl border border-gray-200 bg-white p-5 shadow hover:border-emerald-500">
                            <p class="text-lg font-semibold text-gray-800">{{ $shop->name }}</p>
                            <p class="text-sm text-gray-500">{{ $shop->products_count }} ürün</p>
                            <p class="mt-3 text-sm text-gray-600 truncate">{{ $shop->description }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
