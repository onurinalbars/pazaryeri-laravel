@extends('layouts.app')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-2xl font-bold text-gray-900">Siparişlerim</h1>
        <div class="mt-6 space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('account.orders.show', $order) }}" class="flex flex-col gap-2 rounded-2xl border border-gray-200 p-4 hover:border-emerald-500 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">#{{ $order->id }} - {{ $order->shop->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</p>
                        <p class="text-sm text-gray-500">Durum: {{ ucfirst($order->status) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
