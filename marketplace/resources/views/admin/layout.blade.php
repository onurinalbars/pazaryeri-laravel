@extends('layouts.app')

@section('content')
    @php
        $pageTitle = trim($__env->yieldContent('page-title', 'Yönetim Paneli'));
        $pageDescription = trim($__env->yieldContent('page-description', ''));

        $navigation = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
            ['label' => 'Categories', 'route' => 'admin.categories.index', 'active' => 'admin.categories.*'],
            ['label' => 'Products', 'route' => 'admin.products.index', 'active' => 'admin.products.*'],
            ['label' => 'Listings', 'route' => 'admin.listings.index', 'active' => 'admin.listings.*'],
            ['label' => 'Shops', 'route' => 'admin.shops.index', 'active' => 'admin.shops.*'],
            ['label' => 'Vendors', 'route' => 'admin.vendors.index', 'active' => 'admin.vendors.*'],
            ['label' => 'Orders', 'route' => 'admin.orders.index', 'active' => 'admin.orders.*'],
            ['label' => 'Users', 'route' => 'admin.users.index', 'active' => 'admin.users.*'],
            ['label' => 'Sliders', 'route' => 'admin.sliders.index', 'active' => 'admin.sliders.*'],
            ['label' => 'Banners', 'route' => 'admin.banners.index', 'active' => 'admin.banners.*'],
            ['label' => 'Site Settings', 'route' => 'admin.settings.site.edit', 'active' => 'admin.settings.site.*'],
            ['label' => 'Payment Settings', 'route' => 'admin.settings.payment.edit', 'active' => 'admin.settings.payment.*'],
        ];
    @endphp

    <div class="flex flex-col gap-6 lg:flex-row">
        <aside class="lg:w-64">
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">Admin Menu</p>
                <nav class="mt-4 space-y-1 text-sm font-medium">
                    @foreach($navigation as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="{{ request()->routeIs($item['active']) ? 'bg-emerald-50 text-emerald-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50' }} flex items-center justify-between rounded-xl px-4 py-2 transition"
                        >
                            <span>{{ $item['label'] }}</span>
                            @if(request()->routeIs($item['active']))
                                <span class="text-xs font-semibold">●</span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>
            <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-900">
                <p class="font-semibold">Hızlı Erişim</p>
                <p class="mt-1">
                    <a href="{{ route('home') }}" class="font-medium text-emerald-700 underline">Siteyi Gör</a>
                </p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-red-600 hover:underline">Çıkış yap</button>
                </form>
            </div>
        </aside>

        <section class="flex-1 space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white px-6 py-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Admin Panel</p>
                <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $pageTitle }}</h1>
                        @if($pageDescription)
                            <p class="text-sm text-gray-500">{{ $pageDescription }}</p>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500">{{ now()->format('d M Y') }}</p>
                </div>
            </div>

            <div>
                @yield('admin-content')
            </div>
        </section>
    </div>
@endsection
