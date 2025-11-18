@extends('admin.layout')

@section('page-title', 'Slider Yönetimi')
@section('page-description', 'Ana sayfa kahraman alanını yönetin ve kampanyalarınızı öne çıkarın.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-2">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Toplam Slider</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Aktif Gösterim</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['active']) }}</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Slider Listesi</h2>
            <p class="text-sm text-gray-500">Sıra numarasına göre listelenir</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
            + Yeni Slider
        </a>
    </div>

    <div class="mt-4 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-4 py-3">Başlık</th>
                    <th class="px-4 py-3">Bağlantı</th>
                    <th class="px-4 py-3">Sıra</th>
                    <th class="px-4 py-3 text-right">Durum</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sliders as $slider)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-900">{{ $slider->title }}</p>
                            <p class="text-xs text-gray-500">{{ $slider->subtitle }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-emerald-600">
                            @if($slider->link_url)
                                <a href="{{ $slider->link_url }}" target="_blank" class="hover:underline">{{ $slider->link_url }}</a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $slider->sort_order }}</td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $slider->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $slider->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-sm font-semibold text-emerald-600 hover:underline">Düzenle</a>
                                <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" onsubmit="return confirm('Sliderı silmek istiyor musunuz?')">
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
            {{ $sliders->links() }}
        </div>
    </div>
@endsection
