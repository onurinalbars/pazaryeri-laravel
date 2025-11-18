<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VendorShopController extends Controller
{
    public function edit(Request $request)
    {
        $shop = $request->user()->shop;

        return view('vendor.shop.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = $request->user()->shop;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('shops', 'slug')->ignore($shop->id)],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            if ($shop->logo) {
                Storage::disk('public')->delete($shop->logo);
            }

            $data['logo'] = $request->file('logo')->store('shops', 'public');
        }

        $shop->update($data);

        return back()->with('success', 'Shop settings updated.');
    }
}
