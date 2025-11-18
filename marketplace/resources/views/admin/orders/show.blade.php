@extends('admin.layout')

@section('page-title', 'Sipariş Detayı')
@section('page-description', '#'.$order->id)

@section('admin-content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-widest text-gray-500">Sipariş</p>
                        <h2 class="text-2xl font-semibold text-gray-900">#{{ $order->id }}</h2>
                        <p class="text-sm text-gray-500">Mağaza: {{ $order->shop?->name ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm uppercase tracking-widest text-gray-500">Toplam</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</p>
                    </div>
                </div>
                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase tracking-widest text-gray-500">Müşteri</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $order->user->name }}</dd>
                        <dd class="text-sm text-gray-500">{{ $order->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-widest text-gray-500">Durum</dt>
                        <dd class="mt-1 flex flex-wrap gap-2">
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold capitalize text-gray-700">{{ $order->status }}</span>
                            <span class="rounded-full {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-yellow-50 text-yellow-700' }} px-3 py-1 text-xs font-semibold capitalize">
                                {{ $order->payment_status }} ödeme
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Sipariş Öğeleri</h3>
                <div class="mt-4 divide-y divide-gray-100 text-sm">
                    @foreach($order->items as $item)
                        <div class="flex flex-col gap-2 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item->product?->name ?? 'Ürün #' . $item->product_id }}</p>
                                <p class="text-xs text-gray-500">Adet: {{ $item->quantity }}</p>
                            </div>
                            <p class="font-semibold text-gray-900">{{ number_format($item->price * $item->quantity, 2) }} ₺</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Adres Bilgileri</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">Teslimat</p>
                        <p class="mt-1 text-sm text-gray-600">
                            @if(is_array($order->shipping_address))
                                {{ $order->shipping_address['line1'] ?? '' }}<br>
                                {{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}
                            @else
                                {{ $order->shipping_address }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">Fatura</p>
                        <p class="mt-1 text-sm text-gray-600">
                            @if(is_array($order->billing_address))
                                {{ $order->billing_address['line1'] ?? '' }}<br>
                                {{ $order->billing_address['city'] ?? '' }} {{ $order->billing_address['zip'] ?? '' }}
                            @else
                                {{ $order->billing_address }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Durum Güncelle</h3>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <label class="text-sm font-semibold text-gray-700">
                        Sipariş Durumu
                        <select name="status" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                            @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="text-sm font-semibold text-gray-700">
                        Ödeme Durumu
                        <select name="payment_status" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                            @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                                <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
                        Kaydet
                    </button>
                </form>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Ödeme Bilgisi</h3>
                <dl class="mt-4 space-y-3 text-sm text-gray-600">
                    <div>
                        <dt class="text-xs uppercase tracking-widest text-gray-500">Transaction</dt>
                        <dd class="font-semibold text-gray-900">{{ $order->transaction_id ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection
