<x-guest-layout>
    <h2 class="text-2xl font-semibold text-gray-900">Vendor Başvurusu</h2>
    <p class="mt-2 text-sm text-gray-600">
        Mağazanızı açmak için bilgilerinizi doldurun. Başvurular admin tarafından onaylandıktan sonra satış yapabilirsiniz.
    </p>

    <form method="POST" action="{{ route('vendor.register.store') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Ad Soyad" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="E-posta" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Şifre" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Şifre Tekrar" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shop_name" value="Mağaza Adı" />
            <x-text-input id="shop_name" name="shop_name" type="text" class="mt-1 block w-full" :value="old('shop_name')" required />
            <x-input-error :messages="$errors->get('shop_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shop_description" value="Mağaza Açıklaması" />
            <textarea id="shop_description" name="shop_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('shop_description') }}</textarea>
            <x-input-error :messages="$errors->get('shop_description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:underline">Zaten hesabınız var mı?</a>
            <x-primary-button>
                Başvuruyu Gönder
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
