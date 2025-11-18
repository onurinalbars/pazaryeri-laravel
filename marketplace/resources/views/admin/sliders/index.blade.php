@extends('layouts.admin')

@section('page-title', 'Slider Yönetimi')

@section('content')
    <div class="flex items-center justify-between rounded-2xl bg-white p-5 shadow">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Sliderlar</h1>
            <p class="text-sm text-gray-500">Ana sayfa görselleri</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Yeni Slider</a>
    </div>

    <div class="mt-6 rounded-2xl bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Başlık</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Durum</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-700">Sıra</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sliders as $slider)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $slider->title }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $slider->is_active ? 'Aktif' : 'Pasif' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $slider->sort_order }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-sm text-emerald-600 hover:underline">Düzenle</a>
                            <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" class="inline">
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
            {{ $sliders->links() }}
        </div>
    </div>
@endsection
