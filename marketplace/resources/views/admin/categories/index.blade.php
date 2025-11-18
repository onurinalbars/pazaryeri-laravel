@extends('layouts.admin')

@section('page-title', 'Kategoriler')

@section('content')
    <div class="flex items-center justify-between rounded-2xl bg-white p-5 shadow">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Kategoriler</h1>
            <p class="text-sm text-gray-500">Tüm kategori kayıtları</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Yeni Kategori</a>
    </div>

    <div class="mt-6 rounded-2xl bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Ad</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Üst</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Durum</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($categories as $category)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->parent?->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->is_active ? 'Aktif' : 'Pasif' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm text-emerald-600 hover:underline">Düzenle</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-sm text-red-600 hover:underline">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
