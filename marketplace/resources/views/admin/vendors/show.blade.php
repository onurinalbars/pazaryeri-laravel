@extends('admin.layout')

@section('page-title', 'Vendor Detayı')
@section('page-description', $vendor->name)

@section('admin-content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-widest text-gray-500">Vendor</p>
                        <h2 class="text-2xl font-semibold text-gray-900">{{ $vendor->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $vendor->email }}</p>
                    </div>
                    @if($shop?->logo)
                        <img src="{{ asset('storage/' . $shop->logo) }}" alt="{{ $shop->name }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-emerald-100">
                    @endif
                </div>
                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase tracking-widest text-gray-500">Mağaza</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $shop->name ?? 'Mağaza bulunamadı' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-widest text-gray-500">Durum</dt>
                        <dd>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $shop?->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-yellow-50 text-yellow-700' }}">
                                {{ $shop?->is_active ? 'Onaylı' : 'Bekliyor' }}
                            </span>
                        </dd>
                    </div>
                </dl>
                @if($shop?->description)
                    <p class="mt-4 text-sm text-gray-600">{{ $shop->description }}</p>
                @endif
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Performans</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">Ürün</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ number_format($stats['products']) }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">İlan</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ number_format($stats['listings']) }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">Sipariş</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ number_format($stats['orders']) }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">Ciro</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900">{{ number_format($stats['revenue'], 2) }} ₺</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Son Siparişler</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-emerald-600 hover:underline">Tümü</a>
                </div>
                <div class="mt-4 divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <div class="flex flex-col gap-1 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                                <p class="text-xs text-gray-500">{{ $order->user->name }}</p>
                            </div>
                            <div class="text-sm text-gray-600 sm:text-right">
                                <p class="font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }} ₺</p>
                                <p class="capitalize text-gray-500">{{ $order->status }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="py-4 text-center text-sm text-gray-500">Bu vendor için sipariş bulunamadı.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Onay Durumu</h3>
                <form method="POST" action="{{ route('admin.vendors.status', $vendor) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <label class="text-sm font-semibold text-gray-700">
                        Durum
                        <select name="status" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                            <option value="approved" @selected($shop?->is_active)>Onayla</option>
                            <option value="suspended" @selected(! $shop?->is_active)>Askıya Al</option>
                        </select>
                    </label>
                    <label class="text-sm font-semibold text-gray-700">
                        Not
                        <textarea name="note" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="İç notlar veya hatırlatmalar"></textarea>
                    </label>
                    <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
                        Durumu Güncelle
                    </button>
                </form>
            </div>

            @if($shop)
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">Mağaza Bilgileri</h3>
                    <dl class="mt-4 space-y-3 text-sm text-gray-600">
                        <div>
                            <dt class="text-xs uppercase tracking-widest text-gray-500">Slug</dt>
                            <dd class="font-semibold text-gray-900">{{ $shop->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-widest text-gray-500">POS Sağlayıcı</dt>
                            <dd>{{ $shop->pos_provider ?? 'Tanımlı değil' }}</dd>
                        </div>
                    </dl>
                </div>
            @endif
        </div>
    </div>
@endsection
