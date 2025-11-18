<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cartService)
    {
        $cart = $cartService->get();

        return view('cart.index', [
            'cart' => $cart,
            'total' => $cartService->totalAmount(),
        ]);
    }

    public function store(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $cartService->add($product, (int) $validated['quantity']);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $cartService->updateQuantity($product->id, (int) $validated['quantity']);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Product $product, CartService $cartService): RedirectResponse
    {
        $cartService->remove($product->id);

        return back()->with('success', 'Item removed.');
    }

    public function clear(CartService $cartService): RedirectResponse
    {
        $cartService->clear();

        return back()->with('success', 'Cart cleared.');
    }
}
