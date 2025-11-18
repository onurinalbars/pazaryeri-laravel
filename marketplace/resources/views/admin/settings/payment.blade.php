@extends('admin.layout')

@section('page-title', 'Ödeme Ayarları')
@section('page-description', 'Platform POS bilgilerini güncelleyin.')

@section('admin-content')
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.settings.payment.update') }}" class="space-y-5">
            @csrf
            <label class="text-sm font-semibold text-gray-700">
                POS Sağlayıcı
                <input type="text" name="provider" value="{{ old('provider', $payment['provider']) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>

            <div class="grid gap-4 md:grid-cols-2">
                <label class="text-sm font-semibold text-gray-700">
                    Merchant ID
                    <input type="text" name="merchant_id" value="{{ old('merchant_id', $payment['merchant_id']) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Terminal ID
                    <input type="text" name="terminal_id" value="{{ old('terminal_id', $payment['terminal_id']) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <label class="text-sm font-semibold text-gray-700">
                    API Key
                    <input type="text" name="api_key" value="{{ old('api_key', $payment['api_key']) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Secret Key
                    <input type="text" name="secret_key" value="{{ old('secret_key', $payment['secret_key']) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
            </div>

            <label class="text-sm font-semibold text-gray-700">
                Callback URL
                <input type="url" name="callback_url" value="{{ old('callback_url', $payment['callback_url']) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
            </label>

            <label class="flex items-center gap-3 text-sm font-semibold text-gray-700">
                <input type="checkbox" name="test_mode" value="1" class="rounded border-gray-300" @checked(old('test_mode', $payment['test_mode']))>
                Test Modu
            </label>

            <button type="submit" class="w-full rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
                Kaydet
            </button>
        </form>
    </div>
@endsection
