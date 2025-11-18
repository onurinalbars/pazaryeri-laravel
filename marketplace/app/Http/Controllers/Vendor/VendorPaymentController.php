<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorSetting;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    public function edit(Request $request)
    {
        $shop = $request->user()->shop;
        $settings = $shop->vendorSetting ?: new VendorSetting(['shop_id' => $shop->id]);

        return view('vendor.payment.edit', compact('shop', 'settings'));
    }

    public function update(Request $request)
    {
        $shop = $request->user()->shop;

        $data = $request->validate([
            'pos_api_key' => ['nullable', 'string', 'max:255'],
            'pos_api_secret' => ['nullable', 'string', 'max:255'],
            'pos_merchant_id' => ['nullable', 'string', 'max:255'],
            'pos_terminal_id' => ['nullable', 'string', 'max:255'],
            'pos_environment' => ['nullable', 'string', 'max:120'],
            'extra_payload' => ['nullable', 'string'],
        ]);

        $extraPayload = null;
        if (! empty($data['extra_payload'])) {
            $decoded = json_decode($data['extra_payload'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withErrors(['extra_payload' => 'Extra payload must be valid JSON.'])
                    ->withInput();
            }

            $extraPayload = $decoded;
        }

        VendorSetting::updateOrCreate(
            ['shop_id' => $shop->id],
            [
                'pos_api_key' => $data['pos_api_key'],
                'pos_api_secret' => $data['pos_api_secret'],
                'pos_merchant_id' => $data['pos_merchant_id'],
                'pos_terminal_id' => $data['pos_terminal_id'],
                'pos_environment' => $data['pos_environment'],
                'extra_payload' => $extraPayload,
            ]
        );

        return back()->with('success', 'Payment settings updated.');
    }
}
