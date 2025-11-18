<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Marketplace') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.13/dist/tailwind.min.css">
        @stack('styles')
    </head>
    <body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">
        <header class="bg-white shadow">
            <div class="container mx-auto flex flex-wrap items-center justify-between px-4 py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-600">
                    {{ config('app.name', 'E-Ticaret') }}
                </a>
                <nav class="flex flex-wrap items-center gap-4 text-sm font-medium text-gray-600">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Ana Sayfa</a>
                    <a href="{{ route('cart.index') }}" class="hover:text-emerald-600">Sepet</a>
                    @auth
                        <a href="{{ route('account.orders.index') }}" class="hover:text-emerald-600">Siparişlerim</a>
                        @if(auth()->user()->isVendor())
                            <a href="{{ route('vendor.dashboard') }}" class="hover:text-emerald-600">Mağazam</a>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline">Çıkış</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-emerald-600">Giriş</a>
                        <a href="{{ route('register') }}" class="hover:text-emerald-600">Kayıt Ol</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="container mx-auto px-4 py-8">
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white py-8 text-center text-sm text-gray-500">
            <p>&copy; {{ now()->year }} {{ config('app.name', 'Marketplace') }}. Tüm hakları saklıdır.</p>
        </footer>

        @stack('scripts')
    </body>
</html>
