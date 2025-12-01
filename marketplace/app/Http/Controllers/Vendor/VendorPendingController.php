<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorPendingController extends Controller
{
    /**
     * Show the pending approval screen for vendors.
     */
    public function __invoke(Request $request)
    {
        return view('vendor.pending', [
            'user' => $request->user(),
            'shop' => $request->user()->shop,
        ]);
    }
}
