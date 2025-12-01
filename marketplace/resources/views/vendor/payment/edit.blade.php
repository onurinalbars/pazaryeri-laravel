@extends('layouts.vendor')

@section('page-title', 'Payment Settings')

@section('content')
    <section class="rounded-2xl bg-white p-6 shadow">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Vendor payout</p>
            <h1 class="text-2xl font-semibold text-gray-900">POS API credentials</h1>
            <p class="text-sm text-gray-500">Store the credentials provided by your payment processor. We keep them encrypted.</p>
        </div>

        <div class="mt-4 rounded-xl border border-gray-100 bg-slate-50/60 p-4 text-xs text-gray-600">
            <p>
                <span class="font-semibold text-gray-800">Current status:</span>
                @if($settings->exists && $settings->updated_at)
                    Updated {{ $settings->updated_at->diffForHumans() }}
                @else
                    Not configured yet
                @endif
            </p>
            <p>Need help? Contact support to verify your integration.</p>
        </div>

        <form method="POST" action="{{ route('vendor.payment.update') }}" class="mt-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid gap-6 md:grid-cols-2">
                <label class="text-sm font-semibold text-gray-700">
                    API Key
                    <input type="text" name="pos_api_key" value="{{ old('pos_api_key', $settings->pos_api_key) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    API Secret
                    <input type="text" name="pos_api_secret" value="{{ old('pos_api_secret', $settings->pos_api_secret) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Merchant ID
                    <input type="text" name="pos_merchant_id" value="{{ old('pos_merchant_id', $settings->pos_merchant_id) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                </label>
                <label class="text-sm font-semibold text-gray-700">
                    Terminal ID
                    <input type="text" name="pos_terminal_id" value="{{ old('pos_terminal_id', $settings->pos_terminal_id) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
                </label>
            </div>

            <label class="text-sm font-semibold text-gray-700">
                Environment (sandbox / production)
                <input type="text" name="pos_environment" value="{{ old('pos_environment', $settings->pos_environment) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500">
            </label>

            <label class="block text-sm font-semibold text-gray-700">
                Extra payload (JSON)
                <textarea name="extra_payload" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500" placeholder='{"callback_url":"https://example.com/callback"}'>{{ old('extra_payload', $settings->extra_payload ? json_encode($settings->extra_payload, JSON_PRETTY_PRINT) : '') }}</textarea>
                <span class="mt-1 block text-xs text-gray-400">Optional advanced configuration fields required by certain POS providers.</span>
            </label>

            <div class="flex justify-end">
                <button type="submit" class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Save credentials</button>
            </div>
        </form>
    </section>
@endsection
