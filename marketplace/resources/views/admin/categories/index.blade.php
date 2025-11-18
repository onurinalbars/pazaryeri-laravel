@extends('admin.layout')

@section('page-title', 'Kategori Yönetimi')
@section('page-description', 'Menü ağacınızı düzenleyin, yeni kategoriler oluşturun ve hiyerarşiyi yönetin.')

@section('admin-content')
    <div class="grid gap-5 md:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Toplam</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Aktif</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-gray-500">Üst Kategoriler</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($stats['top_level']) }}</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Kategori Listesi</h2>
            <p class="text-sm text-gray-500">Tüm kategoriler ve bağlı oldukları üst kategoriler</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
            + Yeni Kategori
        </a>
    </div>

    <div class="mt-4 rounded-2xl border border-gray-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Üst Kategori</th>
                    <th class="px-4 py-3">Durum</th>
                    <th class="px-4 py-3 text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($categories as $category)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                            <p class="text-xs text-gray-500">{{ $category->slug }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ $category->parent?->name ?? '—' }}
                        </td>
                        <td class="px-4 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $category->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right text-sm">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="font-semibold text-emerald-600 hover:underline">Düzenle</a>
                            <form method="POST"
                                  action="{{ route('admin.categories.destroy', $category) }}"
                                  class="mt-2 inline-block"
                                  onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-semibold text-red-600 hover:underline">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-gray-100 px-4 py-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
