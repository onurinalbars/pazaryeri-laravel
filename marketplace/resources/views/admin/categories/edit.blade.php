@extends('admin.layout')

@section('page-title', 'Kategori Düzenle')
@section('page-description', $category->name)

@section('admin-content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Kategori Düzenle</h1>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            @include('admin.categories._form')
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Güncelle</button>
        </form>
    </div>
@endsection
