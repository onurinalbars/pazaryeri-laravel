<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class ListingController extends Controller
{
    public function show(string $slug)
    {
        $listing = Listing::with(['shop', 'category', 'owner'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedListings = Listing::with('shop')
            ->active()
            ->where('category_id', $listing->category_id)
            ->where('id', '!=', $listing->id)
            ->take(4)
            ->get();

        return view('listings.show', [
            'listing' => $listing,
            'relatedListings' => $relatedListings,
        ]);
    }
}
