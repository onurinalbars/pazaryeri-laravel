@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="rounded-2xl bg-white p-6 shadow">
            <h1 class="text-2xl font-bold text-gray-900">Sipariş #{{ $order->id }}</h1>
            <p class="mt-2 text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p class="mt-2 text-sm text-gray-500">Durum: <span class="font-semibold text-emerald-600">{{ ucfirst($order->status) }}</span></p>
            <p class="mt-2 text-sm text-gray-500">Ödeme: {{ ucfirst($order->payment_status) }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold text-gray-800">Adres Bilgileri</h2>
            <p class="mt-2 text-sm text-gray-600">{{ $order->shipping_address['full_name'] ?? '' }}</p>
            <p class="text-sm text-gray-600">{{ $order->shipping_address['phone'] ?? '' }}</p>
            <p class="text-sm text-gray-600">{{ $order->shipping_address['address'] ?? '' }}</p>
            <p class="text-sm text-gray-600">{{ $order->shipping_address['city'] ?? '' }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold text-gray-800">Ürünler</h2>
            <div class="mt-4 space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between text-sm text-gray-700">
                        <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <span>{{ number_format($item->price * $item->quantity, 2) }} ₺</span>
                    </div>
                @endforeach
            </div>
            <p class="mt-6 text-lg font-bold text-gray-900">Toplam: {{ number_format($order->total_amount, 2) }} ₺</p>
        </div>
    </div>
@endsection
