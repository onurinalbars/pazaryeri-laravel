@extends('layouts.vendor')

@section('page-title', 'Ürün Güncelle')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Ürünü Güncelle</h1>
        <form method="POST" action="{{ route('vendor.products.update', $product) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            @include('vendor.products._form')
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Güncelle</button>
        </form>
    </div>
@endsection
