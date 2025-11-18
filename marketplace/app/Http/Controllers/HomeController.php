<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $banners = Banner::where('is_active', true)->get()->groupBy('position');

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $latestProducts = Product::with('shop')
            ->active()
            ->latest()
            ->take(8)
            ->get();

        $latestListings = Listing::with('shop')
            ->active()
            ->latest()
            ->take(6)
            ->get();

        $featuredShops = Shop::active()
            ->withCount('products')
            ->latest()
            ->take(6)
            ->get();

        return view('home', [
            'sliders' => $sliders,
            'banners' => $banners,
            'categories' => $categories,
            'latestProducts' => $latestProducts,
            'latestListings' => $latestListings,
            'featuredShops' => $featuredShops,
        ]);
    }
}
