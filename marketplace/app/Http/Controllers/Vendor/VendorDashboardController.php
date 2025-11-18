<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $shop = $request->user()
            ->shop()
            ->withCount(['products', 'listings'])
            ->firstOrFail();

        $recentOrders = $shop->orders()
            ->latest()
            ->take(5)
            ->with('user')
            ->get();

        $metrics = [
            'total_sales' => $shop->orders()->where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => $shop->orders()->where('status', 'pending')->count(),
            'products' => $shop->products_count,
            'listings' => $shop->listings_count,
        ];

        return view('vendor.dashboard', [
            'shop' => $shop,
            'recentOrders' => $recentOrders,
            'metrics' => $metrics,
            'vendorStatus' => $request->user()->vendor_status,
        ]);
    }
}
