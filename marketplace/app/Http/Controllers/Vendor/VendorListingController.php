<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorListingController extends Controller
{
    public function index(Request $request)
    {
        $listings = $request->user()->shop
            ->listings()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('vendor.listings.index', compact('listings'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->pluck('name', 'id');

        return view('vendor.listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $shop = $request->user()->shop;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['shop_id'] = $shop->id;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('listings', 'public');
        }

        Listing::create($data);

        return redirect()->route('vendor.listings.index')->with('success', 'Listing published.');
    }

    public function edit(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        $categories = Category::where('is_active', true)->pluck('name', 'id');

        return view('vendor.listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($listing->image_path) {
                Storage::disk('public')->delete($listing->image_path);
            }

            $data['image_path'] = $request->file('image')->store('listings', 'public');
        }

        $listing->update($data);

        return redirect()->route('vendor.listings.index')->with('success', 'Listing updated.');
    }

    public function destroy(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        if ($listing->image_path) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $listing->delete();

        return redirect()->route('vendor.listings.index')->with('success', 'Listing removed.');
    }

    protected function authorizeListing(Request $request, Listing $listing): void
    {
        abort_if($listing->shop_id !== $request->user()->shop->id, 403);
    }
}
