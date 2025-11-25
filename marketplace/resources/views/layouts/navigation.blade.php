<nav class="border-b border-gray-100 bg-white">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="text-lg font-semibold text-emerald-600">
                {{ config('app.name', 'Marketplace') }}
            </a>
            <div class="hidden items-center gap-5 text-sm font-medium text-gray-600 md:flex">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-emerald-600' : 'hover:text-emerald-600' }}">Anasayfa</a>
                <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'text-emerald-600' : 'hover:text-emerald-600' }}">Sepetim</a>
            </div>
        </div>
        <div class="flex items-center gap-3 text-sm font-semibold">
            @auth
                @if(auth()->user()->isUser())
                    <a href="{{ route('account.orders.index') }}" class="rounded-full border border-gray-200 px-4 py-2 text-gray-700 hover:border-emerald-200 hover:text-emerald-700">Siparişlerim</a>
                @endif

                @if(auth()->user()->isVendor())
                    <a href="{{ route('vendor.dashboard') }}" class="rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-emerald-700 hover:bg-emerald-100">Vendor Paneli</a>
                @else
                    <a href="{{ route('vendor.register') }}" class="hidden rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-emerald-700 hover:bg-emerald-100 md:inline-flex">Vendor Ol</a>
                @endif

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-gray-200 px-4 py-2 text-gray-700 hover:border-emerald-200 hover:text-emerald-700">Admin</a>
                @endif

                <span class="hidden text-gray-600 md:inline">Merhaba, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-gray-900 px-4 py-2 text-white hover:bg-gray-800">Çıkış</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full border border-gray-200 px-4 py-2 text-gray-700 hover:border-emerald-200 hover:text-emerald-700">Giriş Yap</a>
                <a href="{{ route('register') }}" class="rounded-full border border-gray-200 px-4 py-2 text-gray-700 hover:border-emerald-200 hover:text-emerald-700">Üye Ol</a>
                <a href="{{ route('vendor.register') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-emerald-700 hover:bg-emerald-100">Vendor Ol</a>
            @endauth
        </div>
    </div>
</nav>
