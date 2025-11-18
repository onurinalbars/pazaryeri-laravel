@extends('admin.layout')

@section('page-title', 'Banner Yönetimi')
@section('page-description', 'Tüm banner alanlarını yönetin ve pozisyon bazlı kampanyalar oluşturun.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-2">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Toplam Banner</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Aktif Banner</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['active']) }}</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Banner Listesi</h2>
            <p class="text-sm text-gray-500">Pozisyona göre filtreleyin</p>
        </div>
        <a href="{{ route('admin.banners.create') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
            + Yeni Banner
        </a>
    </div>

    <div class="mt-4 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-4 py-3">Başlık</th>
                    <th class="px-4 py-3">Pozisyon</th>
                    <th class="px-4 py-3">Bağlantı</th>
                    <th class="px-4 py-3 text-right">Durum</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($banners as $banner)
                    <tr>
                        <td class="px-4 py-4 font-semibold text-gray-900">{{ $banner->title }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $banner->position }}</td>
                        <td class="px-4 py-4 text-sm text-emerald-600">
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" target="_blank" class="hover:underline">{{ $banner->link_url }}</a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $banner->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $banner->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="text-sm font-semibold text-emerald-600 hover:underline">Düzenle</a>
                                <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Bannerı silmek istiyor musunuz?')">
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
            {{ $banners->links() }}
        </div>
    </div>
@endsection
