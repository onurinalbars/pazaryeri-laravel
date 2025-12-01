<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Vendor | {{ config('app.name') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.13/dist/tailwind.min.css">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        @stack('styles')
    </head>
    <body class="flex min-h-screen bg-slate-50">
        @php($vendorUser = auth()->user())
        <aside class="hidden w-60 flex-shrink-0 bg-white shadow-md md:block">
            <div class="px-5 py-5 text-lg font-semibold text-emerald-600">
                Vendor Panel
            </div>
            <nav class="space-y-1 px-4 text-sm">
                <a href="{{ route('vendor.dashboard') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.dashboard') ? 'bg-slate-100' : '' }}">Dashboard</a>
                <a href="{{ route('vendor.products.index') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.products.*') ? 'bg-slate-100' : '' }}">Products</a>
                <a href="{{ route('vendor.listings.index') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.listings.*') ? 'bg-slate-100' : '' }}">Listings</a>
                <a href="{{ route('vendor.orders.index') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.orders.*') ? 'bg-slate-100' : '' }}">Orders</a>
                <a href="{{ route('vendor.shop.edit') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.shop.*') ? 'bg-slate-100' : '' }}">Shop Settings</a>
                <a href="{{ route('vendor.payment.edit') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.payment.*') ? 'bg-slate-100' : '' }}">Payment</a>
                @if($vendorUser?->isVendorPending())
                    <a href="{{ route('vendor.pending') }}" class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('vendor.pending') ? 'bg-slate-100' : '' }}">Pending Status</a>
                @endif
            </nav>
        </aside>

        <div class="flex flex-1 flex-col">
            <header class="flex items-center justify-between bg-white px-6 py-4 shadow">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Vendor Panel')</h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                        <p>{{ $vendorUser?->shop->name ?? '' }}</p>
                        @if($vendorUser?->vendor_status)
                            <span @class([
                                'rounded-full px-3 py-0.5 text-xs font-semibold',
                                'bg-emerald-50 text-emerald-700' => $vendorUser->vendor_status === 'approved',
                                'bg-amber-50 text-amber-700' => $vendorUser->vendor_status === 'pending',
                                'bg-rose-50 text-rose-700' => $vendorUser->vendor_status === 'rejected',
                            ])>
                                {{ ucfirst($vendorUser->vendor_status) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('home') }}" class="text-emerald-600 hover:underline">Siteyi Gör</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Çıkış</button>
                    </form>
                </div>
            </header>

                <main class="flex-1 px-6 py-8">
                    @if($vendorUser?->isVendorPending())
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                            <div>
                                <p class="font-semibold">Your vendor account is awaiting approval.</p>
                                <p class="text-xs text-amber-800/80">Management actions are locked until an administrator approves your shop.</p>
                            </div>
                            <a href="{{ route('vendor.pending') }}" class="rounded-full bg-amber-600 px-4 py-1.5 text-xs font-semibold text-white shadow hover:bg-amber-700">View Status</a>
                        </div>
                    @endif

                @if(session('success'))
                    <div class="mb-6 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
