<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('owner')
            ->latest()
            ->paginate(20);

        return view('admin.shops.index', compact('shops'));
    }

    public function create()
    {
        $vendors = User::where('role', 'vendor')->pluck('name', 'id');

        return view('admin.shops.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('shops', 'public');
        } else {
            $data['logo'] = null;
        }

        Shop::create($data);

        return redirect()->route('admin.shops.index')->with('success', 'Shop created.');
    }

    public function edit(Shop $shop)
    {
        $vendors = User::where('role', 'vendor')->pluck('name', 'id');

        return view('admin.shops.edit', compact('shop', 'vendors'));
    }

    public function update(Request $request, Shop $shop)
    {
        $data = $this->validateData($request, $shop->id);

        if ($request->hasFile('logo')) {
            if ($shop->logo) {
                Storage::disk('public')->delete($shop->logo);
            }

            $data['logo'] = $request->file('logo')->store('shops', 'public');
        }

        $shop->update($data);

        return redirect()->route('admin.shops.index')->with('success', 'Shop updated.');
    }

    public function destroy(Shop $shop)
    {
        if ($shop->logo) {
            Storage::disk('public')->delete($shop->logo);
        }

        $shop->delete();

        return back()->with('success', 'Shop deleted.');
    }

    protected function validateData(Request $request, ?int $shopId = null): array
    {
        $slugRule = Rule::unique('shops', 'slug');
        if ($shopId) {
            $slugRule->ignore($shopId);
        }

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}