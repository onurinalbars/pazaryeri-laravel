<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    public function edit(Request $request)
    {
        $shop = $request->user()->shop;

        return view('vendor.payment.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = $request->user()->shop;

        $data = $request->validate([
            'pos_provider' => ['nullable', 'string', 'max:120'],
            'pos_merchant_id' => ['nullable', 'string', 'max:255'],
            'pos_api_key' => ['nullable', 'string', 'max:255'],
            'pos_secret_key' => ['nullable', 'string', 'max:255'],
            'pos_extra_config' => ['nullable', 'string'],
        ]);

        $extraConfig = null;
        if (! empty($data['pos_extra_config'])) {
            $decoded = json_decode($data['pos_extra_config'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors('Extra config must be valid JSON.')->withInput();
            }

            $extraConfig = $decoded;
        }

        $shop->update([
            'pos_provider' => $data['pos_provider'],
            'pos_merchant_id' => $data['pos_merchant_id'],
            'pos_api_key' => $data['pos_api_key'],
            'pos_secret_key' => $data['pos_secret_key'],
            'pos_extra_config' => $extraConfig,
        ]);

        return back()->with('success', 'Payment settings updated.');
    }
}
