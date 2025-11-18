<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();

        $products = Product::with('shop')
            ->active()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12, ['*'], 'products_page');

        $listings = Listing::with('shop')
            ->active()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(10, ['*'], 'listings_page');

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
            'listings' => $listings,
        ]);
    }
}
