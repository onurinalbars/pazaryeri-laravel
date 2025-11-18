<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use App\Services\Cart\CartService;
use App\Services\Payment\VendorPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {
        $cart = $cartService->get();

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->withErrors('Your cart is empty.');
        }

        return view('checkout.index', [
            'cart' => $cart,
            'total' => $cartService->totalAmount(),
        ]);
    }

    public function store(
        Request $request,
        CartService $cartService,
        VendorPaymentService $paymentService
    ): RedirectResponse {
        $cart = $cartService->get();

        if (! $cart['shop_id'] || empty($cart['items'])) {
            return redirect()->route('cart.index')->withErrors('Your cart is empty.');
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $shop = Shop::findOrFail($cart['shop_id']);
        $productIds = collect($cart['items'])->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('Products are no longer available.');
        }

        $userId = $request->user()->id;

        $order = DB::transaction(function () use ($cart, $products, $validated, $shop, $userId) {
            $total = 0;
            $itemsPayload = [];

            foreach ($cart['items'] as $item) {
                $product = $products[$item['product_id']] ?? null;

                if (! $product) {
                    continue;
                }

                $quantity = min($item['quantity'], $product->stock ?: $item['quantity']);
                $lineTotal = $product->price * $quantity;
                $total += $lineTotal;

                $itemsPayload[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            if ($total <= 0) {
                abort(422, 'Unable to create order with zero total.');
            }

            $order = Order::create([
                'user_id' => $userId,
                'shop_id' => $shop->id,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => [
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'notes' => $validated['notes'] ?? null,
                ],
                'billing_address' => null,
            ]);

            foreach ($itemsPayload as $payload) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $payload['product']->id,
                    'quantity' => $payload['quantity'],
                    'price' => $payload['price'],
                ]);

                $payload['product']->decrement('stock', $payload['quantity']);
            }

            return $order->fresh(['items.product', 'shop']);
        });

        $paymentResult = $paymentService->charge($shop, $order);

        $order->payment_status = $paymentResult->successful ? 'paid' : 'failed';
        $order->status = $paymentResult->successful ? 'processing' : 'pending';
        $order->transaction_id = $paymentResult->transactionId;
        $order->save();

        if ($paymentResult->successful) {
            $cartService->clear();

            return redirect()
                ->route('account.orders.show', $order)
                ->with('success', 'Payment successful! Siparişiniz işleme alındı.');
        }

        return redirect()
            ->route('checkout.index')
            ->withErrors($paymentResult->message ?? 'Payment failed. Please try again.');
    }
}
