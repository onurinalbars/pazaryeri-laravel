<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->shop
            ->orders()
            ->with('user')
            ->withCount('items')
            ->latest()
            ->paginate(20);

        return view('vendor.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        $order->load('items.product', 'user');

        return view('vendor.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        $data = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Order status updated.');
    }

    protected function authorizeOrder(Request $request, Order $order): void
    {
        abort_if($order->shop_id !== $request->user()->shop->id, 403);
    }
}
