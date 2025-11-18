@extends('layouts.vendor')

@section('page-title', 'Vendor Dashboard')

@section('content')
    <section class="rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-400 p-6 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-widest text-white/70">Welcome back</p>
                <h1 class="text-3xl font-semibold">{{ auth()->user()->name }}</h1>
                <p class="mt-1 text-sm text-white/80">{{ $shop->name }} &middot; {{ ucfirst($vendorStatus) }} vendor</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('vendor.orders.index') }}" class="rounded-full border border-white/40 px-5 py-2 text-sm font-semibold text-white/90 hover:bg-white/10">View Orders</a>
                <a href="{{ route('vendor.products.create') }}" class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-emerald-600 shadow">Add Product</a>
            </div>
        </div>
        @if($vendorStatus === 'pending')
            <div class="mt-4 rounded-xl bg-white/20 px-4 py-3 text-sm backdrop-blur">
                <p class="font-semibold">Your shop is waiting for admin approval.</p>
                <p class="text-white/80">You can prepare products and settings now, but sales will open once you're approved.</p>
            </div>
        @endif
    </section>

    <section class="mt-8 grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['total_sales'], 2) }} ₺</p>
            <p class="text-xs text-gray-400">Paid orders only</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Pending Orders</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['pending_orders'] }}</p>
            <p class="text-xs text-gray-400">Awaiting fulfilment</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Active Products</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $metrics['products'] }}</p>
            <p class="text-xs text-gray-400">Listings ready to sell</p>
        </div>
    </section>

    <section class="mt-8 rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Recent orders</h2>
                <p class="text-sm text-gray-500">Latest 5 orders placed in your shop</p>
            </div>
            <a href="{{ route('vendor.orders.index') }}" class="text-sm font-semibold text-emerald-600 hover:underline">View all</a>
        </div>
        <div class="mt-5 divide-y divide-gray-100">
            @forelse($recentOrders as $order)
                <article class="flex flex-col gap-2 py-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Order #{{ $order->id }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->name }} &middot; {{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($order->status) }}</span>
                        <a href="{{ route('vendor.orders.show', $order) }}" class="text-emerald-600 hover:underline">Details</a>
                    </div>
                </article>
            @empty
                <p class="py-6 text-center text-sm text-gray-500">No orders yet. Once customers place orders, they will appear here.</p>
            @endforelse
        </div>
    </section>
@endsection
