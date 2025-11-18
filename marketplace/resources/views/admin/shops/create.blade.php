@extends('admin.layout')

@section('page-title', 'Yeni Mağaza')

@section('admin-content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Yeni Mağaza</h1>
        <form method="POST" action="{{ route('admin.shops.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            @include('admin.shops._form')
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Kaydet</button>
        </form>
    </div>
@endsection
