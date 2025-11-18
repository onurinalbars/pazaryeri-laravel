<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user?->isVendor()) {
            abort(403, 'Only vendors can access this area.');
        }

        if ($user->vendor_status === null) {
            $user->forceFill([
                'vendor_status' => User::VENDOR_STATUS_PENDING,
            ])->save();
        }

        if ($user->vendor_status === User::VENDOR_STATUS_SUSPENDED) {
            abort(403, 'Your vendor account is suspended.');
        }

        $pendingAllowedRoutes = [
            'vendor.pending',
            'vendor.shop.edit',
            'vendor.shop.update',
            'vendor.payment.edit',
            'vendor.payment.update',
        ];

        if ($user->vendor_status !== User::VENDOR_STATUS_APPROVED && ! $request->routeIs($pendingAllowedRoutes)) {
            return redirect()->route('vendor.pending');
        }

        if (! $user->shop) {
            $user->shop()->create([
                'name' => $user->name.' Shop',
                'slug' => Str::slug($user->name.' shop').'-'.Str::lower(Str::random(4)),
                'is_active' => false,
            ]);
        }

        return $next($request);
    }
}
