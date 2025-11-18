@extends('layouts.vendor')

@section('page-title', 'Vendor Dashboard')

@section('content')
    <div class="grid gap-6 md:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Toplam Satış</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($metrics['total_sales'], 2) }} ₺</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Bekleyen Sipariş</p>
            <p class="text-2xl font-bold text-gray-900">{{ $metrics['pending_orders'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Ürünler</p>
            <p class="text-2xl font-bold text-gray-900">{{ $metrics['products'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">İlanlar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $metrics['listings'] }}</p>
        </div>
    </div>

    <div class="mt-8 rounded-2xl bg-white p-6 shadow">
        <h2 class="text-lg font-semibold text-gray-800">Son Siparişler</h2>
        <div class="mt-4 space-y-3">
            @foreach($recentOrders as $order)
                <div class="flex items-center justify-between rounded-xl border border-gray-200 p-4">
                    <div>
                        <p class="font-semibold text-gray-800">#{{ $order->id }} - {{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</p>
                        <p class="text-sm text-gray-500">{{ ucfirst($order->status) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
