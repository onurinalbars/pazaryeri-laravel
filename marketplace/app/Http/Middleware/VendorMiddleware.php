<?php

namespace App\Http\Middleware;

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

        if (! $user->shop) {
            $user->shop()->create([
                'name' => $user->name.' Shop',
                'slug' => Str::slug($user->name.' shop').'-'.Str::lower(Str::random(4)),
                'is_active' => false,
            ]);
        }

        if (! $user->isVendorApproved()
            && ! $request->routeIs('vendor.pending')
            && ! $request->routeIs('vendor.dashboard')) {
            return redirect()->route('vendor.pending');
        }

        return $next($request);
    }
}
