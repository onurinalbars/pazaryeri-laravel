@extends('layouts.app')

@section('content')
    <div class="grid gap-8 md:grid-cols-3">
        <div class="md:col-span-2 rounded-2xl bg-white p-6 shadow">
            <h1 class="text-2xl font-bold text-gray-900">Ödeme</h1>
            <form class="mt-6 space-y-4" method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-gray-700">
                        Ad Soyad
                        <input name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="text-sm font-semibold text-gray-700">
                        Telefon
                        <input name="phone" value="{{ old('phone') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-semibold text-gray-700">
                        Şehir
                        <input name="city" value="{{ old('city') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                </div>
                <label class="text-sm font-semibold text-gray-700">
                    Adres
                    <textarea name="address" rows="3" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('address') }}</textarea>
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Not
                    <textarea name="notes" rows="2" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('notes') }}</textarea>
                </label>
                <button type="submit" class="w-full rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-600">Ödemeyi Tamamla</button>
            </form>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold text-gray-800">Sipariş Özeti</h2>
            <div class="mt-4 space-y-3">
                @foreach($cart['items'] as $item)
                    <div class="flex items-center justify-between text-sm text-gray-700">
                        <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                        <span>{{ number_format($item['price'] * $item['quantity'], 2) }} ₺</span>
                    </div>
                @endforeach
            </div>
            <p class="mt-6 text-lg font-bold text-gray-900">Toplam: {{ number_format($total, 2) }} ₺</p>
        </div>
    </div>
@endsection
