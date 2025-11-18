@extends('layouts.vendor')

@section('page-title', 'Ödeme Ayarları')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow">
        <h1 class="text-xl font-semibold text-gray-800">Sanal POS Bilgileri</h1>
        <form method="POST" action="{{ route('vendor.payment.update') }}" class="mt-6 space-y-4">
            @csrf
            <label class="text-sm font-semibold text-gray-700">
                Sağlayıcı
                <input type="text" name="pos_provider" value="{{ old('pos_provider', $shop->pos_provider) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="text-sm font-semibold text-gray-700">
                    Merchant ID
                    <input type="text" name="pos_merchant_id" value="{{ old('pos_merchant_id', $shop->pos_merchant_id) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    API Key
                    <input type="text" name="pos_api_key" value="{{ old('pos_api_key', $shop->pos_api_key) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
            </div>
            <label class="text-sm font-semibold text-gray-700">
                Secret Key
                <input type="text" name="pos_secret_key" value="{{ old('pos_secret_key', $shop->pos_secret_key) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>
            <label class="text-sm font-semibold text-gray-700">
                Ek Ayarlar (JSON)
                <textarea name="pos_extra_config" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('pos_extra_config', $shop->pos_extra_config ? json_encode($shop->pos_extra_config, JSON_PRETTY_PRINT) : '') }}</textarea>
            </label>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Kaydet</button>
        </form>
    </div>
@endsection
