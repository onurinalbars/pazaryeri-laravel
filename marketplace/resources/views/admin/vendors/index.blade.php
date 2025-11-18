@extends('admin.layout')

@section('page-title', 'Vendor Yönetimi')
@section('page-description', 'Vendor başvurularını inceleyin, mağaza durumlarını ve performanslarını takip edin.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Toplam Vendor</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($metrics['total']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Onaylı</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($metrics['approved']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Bekleyen Onay</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($metrics['pending']) }}</p>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-4 py-3">Vendor</th>
                    <th class="px-4 py-3">Mağaza</th>
                    <th class="px-4 py-3">Ürün</th>
                    <th class="px-4 py-3">Sipariş</th>
                    <th class="px-4 py-3 text-right">Durum</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($vendors as $vendor)
                    @php($shop = $vendor->shop)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-900">{{ $vendor->name }}</p>
                            <p class="text-xs text-gray-500">{{ $vendor->email }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600">
                            {{ $shop?->name ?? 'Mağaza tanımlı değil' }}
                        </td>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ number_format($shop->products_count ?? 0) }}</td>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ number_format($shop->orders_count ?? 0) }}</td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $shop?->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-yellow-50 text-yellow-700' }}">
                                    {{ $shop?->is_active ? 'Onaylı' : 'Bekliyor' }}
                                </span>
                                <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-sm font-semibold text-emerald-600 hover:underline">
                                    Detay
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-gray-100 px-4 py-4">
            {{ $vendors->links() }}
        </div>
    </div>
@endsection
