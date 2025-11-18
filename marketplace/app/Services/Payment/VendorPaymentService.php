<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Shop;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VendorPaymentService
{
    /**
     * Charge an order using vendor-specific virtual POS credentials.
     */
    public function charge(Shop $shop, Order $order): PaymentResult
    {
        if (! $shop->pos_provider || ! $shop->pos_merchant_id) {
            return PaymentResult::failure('Vendor POS configuration is incomplete.');
        }

        $provider = strtolower($shop->pos_provider);

        try {
            return match ($provider) {
                'paytr' => $this->simulateCharge($shop, $order, 'PAYTR'),
                'iyzico' => $this->simulateCharge($shop, $order, 'IYZ'),
                'param' => $this->simulateCharge($shop, $order, 'PARAM'),
                default => $this->simulateCharge($shop, $order, strtoupper($provider)),
            };
        } catch (\Throwable $exception) {
            Log::error('Vendor payment failed', [
                'shop_id' => $shop->id,
                'order_id' => $order->id,
                'error' => $exception->getMessage(),
            ]);

            return PaymentResult::failure('An unexpected error occurred while processing the payment.');
        }
    }

    /**
     * Simulate a payment gateway call.
     *
     * Replace this method with real HTTP integration for the provider.
     */
    protected function simulateCharge(Shop $shop, Order $order, string $gatewayCode): PaymentResult
    {
        Log::info("Simulating {$gatewayCode} charge", [
            'shop' => $shop->id,
            'order' => $order->id,
            'amount' => $order->total_amount,
        ]);

        // TODO: Replace with actual API request/response handling.
        $transactionId = $gatewayCode.'-'.Str::upper(Str::random(10));

        return PaymentResult::success($transactionId, 'Simulated payment success.');
    }
}
