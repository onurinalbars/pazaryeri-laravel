@extends('layouts.app')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-2xl font-bold text-gray-900">Sepetiniz</h1>

        @if(empty($cart['items']))
            <p class="mt-6 text-gray-500">Sepetiniz boş.</p>
        @else
            <div class="mt-6 space-y-4">
                @foreach($cart['items'] as $item)
                    <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 p-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ number_format($item['price'], 2) }} ₺</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 rounded-lg border border-gray-300 px-2 py-1">
                                <button type="submit" class="rounded-full bg-emerald-500 px-3 py-1 text-sm font-semibold text-white hover:bg-emerald-600">Güncelle</button>
                            </form>
                            <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Sil</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p class="text-xl font-bold text-gray-900">Toplam: {{ number_format($total, 2) }} ₺</p>
                <div class="flex gap-3">
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 hover:border-red-400 hover:text-red-600">Sepeti Temizle</button>
                    </form>
                    <a href="{{ route('checkout.index') }}" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Ödeme Yap</a>
                </div>
            </div>
        @endif
    </div>
@endsection
