@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-2xl bg-white p-6 shadow">
        <h1 class="text-2xl font-bold text-gray-900">Giriş Yap</h1>
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf
            <label class="text-sm font-semibold text-gray-700">
                E-posta
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="text-sm font-semibold text-gray-700">
                Şifre
                <input type="password" name="password" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                Beni hatırla
            </label>
            <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Giriş Yap</button>
        </form>
    </div>
@endsection
