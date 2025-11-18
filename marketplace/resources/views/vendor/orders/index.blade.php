@extends('layouts.vendor')

@section('page-title', 'Siparişler')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Mağaza Siparişleri</h1>
        <div class="mt-6 space-y-4">
            @foreach($orders as $order)
                <div class="flex flex-col gap-3 rounded-2xl border border-gray-200 p-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">#{{ $order->id }} - {{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="font-semibold text-gray-700">{{ number_format($order->total_amount, 2) }} ₺</span>
                        <span class="text-gray-500">{{ ucfirst($order->status) }}</span>
                        <a href="{{ route('vendor.orders.show', $order) }}" class="rounded-full border border-gray-300 px-4 py-1 text-gray-700 hover:border-emerald-400 hover:text-emerald-600">Detay</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
