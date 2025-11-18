@extends('admin.layout')

@section('page-title', 'Sipariş Yönetimi')
@section('page-description', 'Platformdaki tüm siparişleri izleyin ve durum güncellemelerini gerçekleştirin.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-4">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Toplam</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Bekleyen</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['pending']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Ödenen</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['paid']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Ciro</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['revenue'], 2) }} ₺</p>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-4 py-3">Sipariş</th>
                    <th class="px-4 py-3">Müşteri</th>
                    <th class="px-4 py-3">Mağaza</th>
                    <th class="px-4 py-3">Toplam</th>
                    <th class="px-4 py-3">Ödeme</th>
                    <th class="px-4 py-3 text-right">Durum</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-4 font-semibold text-gray-900">#{{ $order->id }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $order->user->name }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $order->shop?->name ?? '—' }}</td>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</td>
                        <td class="px-4 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-yellow-50 text-yellow-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold bg-gray-100 capitalize text-gray-700">
                                    {{ $order->status }}
                                </span>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-emerald-600 hover:underline">Detay</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-gray-100 px-4 py-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
