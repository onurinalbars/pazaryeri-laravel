@extends('layouts.vendor')

@section('page-title', "Order #{$order->id}")

@section('content')
    @php
        $shipping = is_array($order->shipping_address) ? $order->shipping_address : [];
        $billing = is_array($order->billing_address) ? $order->billing_address : [];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl bg-white p-6 shadow">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Order summary</p>
                    <h1 class="text-2xl font-semibold text-gray-900">Order #{{ $order->id }}</h1>
                    <p class="text-sm text-gray-500">Placed {{ $order->created_at->format('d M Y H:i') }} by {{ $order->user->name }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-700">{{ ucfirst($order->status) }}</span>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-700">{{ ucfirst($order->payment_status) }}</span>
                    <span class="text-lg font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</span>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-gray-100 p-4">
                    <p class="text-sm font-semibold text-gray-600">Shipping address</p>
                    <p class="mt-2 text-sm text-gray-800">
                        {{ $shipping['name'] ?? $order->user->name }}<br>
                        {{ $shipping['line1'] ?? '' }} {{ $shipping['line2'] ?? '' }}<br>
                        {{ $shipping['city'] ?? '' }} {{ $shipping['postal_code'] ?? '' }}<br>
                        {{ $shipping['country'] ?? '' }}
                    </p>
                    @if(!empty($shipping['phone']))
                        <p class="mt-2 text-xs text-gray-500">Phone: {{ $shipping['phone'] }}</p>
                    @endif
                </div>
                <div class="rounded-xl border border-gray-100 p-4">
                    <p class="text-sm font-semibold text-gray-600">Billing address</p>
                    <p class="mt-2 text-sm text-gray-800">
                        {{ $billing['name'] ?? $order->user->name }}<br>
                        {{ $billing['line1'] ?? '' }} {{ $billing['line2'] ?? '' }}<br>
                        {{ $billing['city'] ?? '' }} {{ $billing['postal_code'] ?? '' }}<br>
                        {{ $billing['country'] ?? '' }}
                    </p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-lg font-semibold text-gray-900">Line items</h2>
            <div class="mt-4 overflow-hidden rounded-xl border border-gray-100">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-left">Quantity</th>
                            <th class="px-4 py-3 text-left">Unit price</th>
                            <th class="px-4 py-3 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 bg-white">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $item->product->name ?? 'Deleted product' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ number_format($item->price, 2) }} ₺</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ number_format($item->price * $item->quantity, 2) }} ₺</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50 text-sm font-semibold text-gray-900">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right">Total</td>
                            <td class="px-4 py-3">{{ number_format($order->total_amount, 2) }} ₺</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-lg font-semibold text-gray-900">Update fulfilment status</h2>
            <p class="text-sm text-gray-500">Customers will see the updated status instantly in their account area.</p>
            <form method="POST" action="{{ route('vendor.orders.update', $order) }}" class="mt-4 flex flex-col gap-3 md:flex-row md:items-center">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500 md:w-auto">
                    @foreach(['pending','processing','shipped','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Save status</button>
            </form>
        </section>
    </div>
@endsection
