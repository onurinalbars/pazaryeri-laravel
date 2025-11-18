<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function orders(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('shop')
            ->latest()
            ->paginate(15);

        return view('account.orders.index', compact('orders'));
    }

    public function show(Order $order, Request $request)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $order->load('items.product', 'shop');

        return view('account.orders.show', compact('order'));
    }
}
