<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with(['shop', 'category'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedProducts = Product::with('shop')
            ->active()
            ->where('shop_id', $product->shop_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
