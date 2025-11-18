<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')
            ->with(['shop' => function ($query) {
                $query->withCount(['products', 'orders']);
            }])
            ->latest()
            ->paginate(20);

        $metrics = [
            'total' => User::where('role', 'vendor')->count(),
            'approved' => User::where('role', 'vendor')
                ->whereHas('shop', fn ($query) => $query->where('is_active', true))
                ->count(),
            'pending' => User::where('role', 'vendor')
                ->whereHas('shop', fn ($query) => $query->where('is_active', false))
                ->count(),
        ];

        return view('admin.vendors.index', compact('vendors', 'metrics'));
    }

    public function show(User $vendor)
    {
        $this->ensureVendor($vendor);

        $vendor->load([
            'shop' => function ($query) {
                $query->withCount(['products', 'listings', 'orders']);
            },
        ]);

        $shop = $vendor->shop;
        $stats = [
            'products' => $shop?->products_count ?? 0,
            'listings' => $shop?->listings_count ?? 0,
            'orders' => $shop?->orders_count ?? 0,
            'revenue' => $shop ? $shop->orders()->sum('total_amount') : 0,
        ];

        $recentOrders = $shop
            ? $shop->orders()->with('user')->latest()->take(5)->get()
            : collect();

        return view('admin.vendors.show', compact('vendor', 'shop', 'stats', 'recentOrders'));
    }

    public function updateStatus(Request $request, User $vendor)
    {
        $this->ensureVendor($vendor);

        $data = $request->validate([
            'status' => ['required', 'in:approved,suspended'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $shop = $vendor->shop;

        if (! $shop) {
            return back()->withErrors('Bu vendora ait mağaza bulunamadı.');
        }

        $shop->update([
            'is_active' => $data['status'] === 'approved',
        ]);

        return back()->with('success', 'Vendor durumu güncellendi.');
    }

    protected function ensureVendor(User $user): void
    {
        abort_if($user->role !== 'vendor', 404);
    }
}
