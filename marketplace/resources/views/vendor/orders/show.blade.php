@extends('layouts.vendor')

@section('page-title', 'Sipariş Detayı')

@section('content')
    <div class="space-y-8">
        <div class="rounded-2xl bg-white p-6 shadow">
            <h1 class="text-xl font-semibold text-gray-800">Sipariş #{{ $order->id }}</h1>
            <p class="text-sm text-gray-500">{{ $order->user->name }} - {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p class="mt-2 text-sm text-gray-500">Durum: {{ ucfirst($order->status) }}</p>
            <p class="text-sm text-gray-500">Ödeme: {{ ucfirst($order->payment_status) }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-lg font-semibold text-gray-800">Ürünler</h2>
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

        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-lg font-semibold text-gray-800">Durum Güncelle</h2>
            <form method="POST" action="{{ route('vendor.orders.update', $order) }}" class="mt-4 flex flex-col gap-3 md:flex-row md:items-center">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-lg border border-gray-300 px-3 py-2">
                    @foreach(['pending','processing','shipped','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Güncelle</button>
            </form>
        </div>
    </div>
@endsection
