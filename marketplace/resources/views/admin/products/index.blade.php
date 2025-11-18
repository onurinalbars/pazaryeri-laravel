@extends('admin.layout')

@section('page-title', 'Ürün Yönetimi')
@section('page-description', 'Tüm ürün envanterini yönetin, fiyatları ve stok durumlarını takip edin.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Toplam Ürün</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Aktif</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Düşük Stok (&lt;10)</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['low_stock']) }}</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Ürün Listesi</h2>
            <p class="text-sm text-gray-500">Mağazalarınıza ait ürün kayıtları</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
            + Yeni Ürün
        </a>
    </div>

    <div class="mt-4 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-4 py-3">Ürün</th>
                    <th class="px-4 py-3">Mağaza</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Fiyat</th>
                    <th class="px-4 py-3 text-right">Durum</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">#{{ $product->id }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $product->shop->name }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-4 py-4">
                            <span class="font-semibold {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ number_format($product->price, 2) }} ₺</td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-sm font-semibold text-emerald-600 hover:underline">Düzenle</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Ürünü silmek istiyor musunuz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-red-600 hover:underline">Sil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-gray-100 px-4 py-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
