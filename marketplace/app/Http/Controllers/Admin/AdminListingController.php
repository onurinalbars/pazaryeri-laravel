<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminListingController extends Controller
{
    public function index()
    {
        $listings = Listing::with(['shop', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('admin.listings.create', [
            'shops' => Shop::pluck('name', 'id'),
            'categories' => Category::pluck('name', 'id'),
            'users' => User::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('listings', 'public');
        }

        Listing::create($data);

        return redirect()->route('admin.listings.index')->with('success', 'Listing created.');
    }

    public function edit(Listing $listing)
    {
        return view('admin.listings.edit', [
            'listing' => $listing,
            'shops' => Shop::pluck('name', 'id'),
            'categories' => Category::pluck('name', 'id'),
            'users' => User::pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($listing->image_path) {
                Storage::disk('public')->delete($listing->image_path);
            }

            $data['image_path'] = $request->file('image')->store('listings', 'public');
        }

        $listing->update($data);

        return redirect()->route('admin.listings.index')->with('success', 'Listing updated.');
    }

    public function destroy(Listing $listing)
    {
        if ($listing->image_path) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $listing->delete();

        return back()->with('success', 'Listing deleted.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'shop_id' => ['nullable', 'exists:shops,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ];
    }
}