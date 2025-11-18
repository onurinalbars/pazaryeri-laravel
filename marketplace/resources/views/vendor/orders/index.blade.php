@extends('layouts.vendor')

@section('page-title', 'Order Management')

@section('content')
    <section class="rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Orders</p>
            <h1 class="text-2xl font-semibold text-gray-900">Customer orders</h1>
            <p class="text-sm text-gray-500">Track payment status, fulfilment progress, and open each order for detailed item management.</p>
        </div>

        <div class="mt-6 space-y-4">
            @forelse($orders as $order)
                <article class="rounded-2xl border border-gray-100 bg-slate-50/40 p-4 shadow-sm hover:border-emerald-200">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-base font-semibold text-gray-900">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->name }} &middot; {{ $order->created_at->format('d M Y H:i') }}</p>
                            <p class="text-xs text-gray-400">{{ $order->items_count }} items</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-sm">
                            <span class="font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($order->status) }}</span>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($order->payment_status) }}</span>
                            <a href="{{ route('vendor.orders.show', $order) }}" class="rounded-full border border-gray-200 px-4 py-1 text-sm font-semibold text-gray-700 hover:border-emerald-400 hover:text-emerald-600">View</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-xl border border-dashed border-gray-200 bg-white px-6 py-10 text-center">
                    <p class="text-sm font-semibold text-gray-600">No orders yet.</p>
                    <p class="text-xs text-gray-500">Once customers purchase from your shop, orders will appear in this list.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </section>
@endsection
