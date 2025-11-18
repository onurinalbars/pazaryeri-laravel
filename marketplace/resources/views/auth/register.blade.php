@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-2xl bg-white p-6 shadow">
        <h1 class="text-2xl font-bold text-gray-900">Kayıt Ol</h1>
        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf
            <label class="text-sm font-semibold text-gray-700">
                Ad Soyad
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="text-sm font-semibold text-gray-700">
                E-posta
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="text-sm font-semibold text-gray-700">
                    Şifre
                    <input type="password" name="password" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Şifre Tekrar
                    <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
            </div>
            <label class="flex items-start gap-2 text-sm text-gray-600">
                <input type="checkbox" name="register_as_vendor" value="1" class="mt-1 rounded border-gray-300" @checked(old('register_as_vendor'))>
                <span>Mağaza sahibi olmak istiyorum</span>
            </label>
            <label class="text-sm font-semibold text-gray-700">
                Mağaza İsmi (opsiyonel)
                <input type="text" name="shop_name" value="{{ old('shop_name') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="Örn. DigitalCity">
            </label>
            <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Kayıt Ol</button>
        </form>
    </div>
@endsection
