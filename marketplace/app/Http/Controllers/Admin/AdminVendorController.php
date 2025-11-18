<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', User::ROLE_VENDOR)
            ->with(['shop' => function ($query) {
                $query->withCount(['products', 'orders']);
            }])
            ->latest()
            ->paginate(20);

        $metrics = [
            'total' => User::where('role', User::ROLE_VENDOR)->count(),
            'approved' => User::where('role', User::ROLE_VENDOR)
                ->where('vendor_status', User::VENDOR_STATUS_APPROVED)
                ->count(),
            'pending' => User::where('role', User::ROLE_VENDOR)
                ->where('vendor_status', User::VENDOR_STATUS_PENDING)
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
            'status' => ['required', 'in:pending,approved,suspended'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $shop = $vendor->shop;

        $vendor->update([
            'vendor_status' => $data['status'],
        ]);

        if ($shop) {
            $shop->update([
                'is_active' => $data['status'] === User::VENDOR_STATUS_APPROVED,
            ]);
        }

        return back()->with('success', 'Vendor durumu güncellendi.');
    }

    protected function ensureVendor(User $user): void
    {
        abort_if($user->role !== User::ROLE_VENDOR, 404);
    }
}
