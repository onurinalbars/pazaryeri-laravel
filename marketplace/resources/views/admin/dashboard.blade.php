@extends('admin.layout')

@section('page-title', 'Yönetim Paneli')
@section('page-description', 'Platform metriklerini takip edin ve önemli aksiyonları hızlıca yönetin.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Vendorlar</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['vendors']) }}</p>
            <p class="text-xs text-gray-500">Aktif mağaza sahipleri</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Müşteriler</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['customers']) }}</p>
            <p class="text-xs text-gray-500">Toplam kayıtlı kullanıcı</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Ürünler</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['products']) }}</p>
            <p class="text-xs text-gray-500">Stoktaki ürünler</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Ciro</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($metrics['sales'], 2) }} ₺</p>
            <p class="text-xs text-gray-500">Ödenmiş sipariş toplamı</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Son Siparişler</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-emerald-600 hover:underline">Tümü</a>
            </div>
            <div class="mt-4 divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                    <div class="flex flex-col gap-1 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">#{{ $order->id }} · {{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->shop->name }}</p>
                        </div>
                        <div class="text-sm text-gray-600 sm:text-right">
                            <p class="font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</p>
                            <p class="capitalize text-gray-500">{{ $order->status }}</p>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-gray-500">Henüz sipariş bulunmuyor.</p>
                @endforelse
            </div>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Operasyon Özeti</h2>
            <div class="mt-4 space-y-4 text-sm text-gray-600">
                <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-3">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-emerald-800">Listelemeler</p>
                        <p class="text-base font-semibold text-gray-900">{{ number_format($metrics['listings']) }}</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700">Aktif</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-3">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-emerald-800">Mağazalar</p>
                        <p class="text-base font-semibold text-gray-900">{{ number_format($metrics['shops']) }}</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700">Canlı</span>
                </div>
                <p class="text-xs text-gray-500">Raporlarınızı veya manuel notlarınızı buraya ekleyerek yönetime aktarabilirsiniz.</p>
            </div>
        </div>
    </div>
@endsection
