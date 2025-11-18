<?php

namespace App\Services\Cart;

use App\Models\Product;
use Illuminate\Support\Arr;

class CartService
{
    public const SESSION_KEY = 'cart';

    public function get(): array
    {
        return session(self::SESSION_KEY, $this->fresh());
    }

    public function add(Product $product, int $quantity = 1): array
    {
        $cart = $this->get();

        if ($cart['shop_id'] && $cart['shop_id'] !== $product->shop_id) {
            $cart = $this->fresh();
        }

        $cart['shop_id'] = $product->shop_id;
        $existingIndex = collect($cart['items'])->search(fn ($item) => $item['product_id'] === $product->id);

        if ($existingIndex !== false) {
            $cart['items'][$existingIndex]['quantity'] += $quantity;
        } else {
            $cart['items'][] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $quantity,
                'image_path' => $product->image_path,
            ];
        }

        return $this->store($cart);
    }

    public function updateQuantity(int $productId, int $quantity): array
    {
        $cart = $this->get();
        $cart['items'] = collect($cart['items'])
            ->map(function ($item) use ($productId, $quantity) {
                if ($item['product_id'] === $productId) {
                    $item['quantity'] = max(1, $quantity);
                }

                return $item;
            })
            ->values()
            ->all();

        return $this->store($cart);
    }

    public function remove(int $productId): array
    {
        $cart = $this->get();
        $cart['items'] = collect($cart['items'])
            ->reject(fn ($item) => $item['product_id'] === $productId)
            ->values()
            ->all();

        if (empty($cart['items'])) {
            $cart = $this->fresh();
        }

        return $this->store($cart);
    }

    public function clear(): array
    {
        session()->forget(self::SESSION_KEY);

        return $this->fresh();
    }

    public function totalAmount(): float
    {
        return (float) collect($this->get()['items'])
            ->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    public function totalQuantity(): int
    {
        return (int) collect($this->get()['items'])
            ->sum(fn ($item) => $item['quantity']);
    }

    protected function fresh(): array
    {
        return [
            'shop_id' => null,
            'items' => [],
        ];
    }

    protected function store(array $cart): array
    {
        $cart['items'] = Arr::wrap($cart['items']);
        session([self::SESSION_KEY => $cart]);

        return $cart;
    }
}
