<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'vendors' => User::where('role', User::ROLE_VENDOR)->count(),
            'customers' => User::where('role', User::ROLE_USER)->count(),
            'products' => Product::count(),
            'listings' => Listing::count(),
            'shops' => Shop::count(),
            'sales' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];

        $recentOrders = Order::with(['shop', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('metrics', 'recentOrders'));
    }
}
