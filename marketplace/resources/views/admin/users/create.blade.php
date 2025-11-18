@extends('layouts.admin')

@section('page-title', 'Yeni Kullanıcı')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Yeni Kullanıcı</h1>
        <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-4">
            @csrf
            @include('admin.users._form')
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Kaydet</button>
        </form>
    </div>
@endsection
