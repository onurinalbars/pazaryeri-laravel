@extends('layouts.admin')

@section('page-title', 'Yönetim Paneli')

@section('content')
    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Toplam Vendor</p>
            <p class="text-3xl font-bold text-gray-900">{{ $metrics['vendors'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Müşteriler</p>
            <p class="text-3xl font-bold text-gray-900">{{ $metrics['customers'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow">
            <p class="text-sm text-gray-500">Toplam Satış</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($metrics['sales'], 2) }} ₺</p>
        </div>
    </div>

    <div class="mt-8 rounded-2xl bg-white p-6 shadow">
        <h2 class="text-lg font-semibold text-gray-800">Son Siparişler</h2>
        <div class="mt-4 space-y-3">
            @foreach($recentOrders as $order)
                <div class="flex items-center justify-between rounded-xl border border-gray-200 p-4">
                    <div>
                        <p class="font-semibold text-gray-800">#{{ $order->id }} - {{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->shop->name }}</p>
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
