<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App.Models\Product;
use App\Models\Shop;

class ShopController extends Controller
{
    public function show(string $slug)
    {
        $shop = Shop::with('owner')->where('slug', $slug)->firstOrFail();

        abort_if(! $shop->is_active, 404);

        $products = Product::with('category')
            ->active()
            ->where('shop_id', $shop->id)
            ->paginate(12);

        $listings = Listing::with('category')
            ->active()
            ->where('shop_id', $shop->id)
            ->paginate(10);

        return view('shops.show', [
            'shop' => $shop,
            'products' => $products,
            'listings' => $listings,
        ]);
    }
}
