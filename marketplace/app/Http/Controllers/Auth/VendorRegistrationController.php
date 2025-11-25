<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class VendorRegistrationController extends Controller
{
    /**
     * Show the vendor registration form.
     */
    public function create(): View
    {
        return view('auth.vendor-register');
    }

    /**
     * Handle the vendor registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $vendor = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_VENDOR,
            'vendor_status' => User::VENDOR_STATUS_PENDING,
        ]);

        $vendor->shop()->create([
            'name' => $data['shop_name'],
            'slug' => Str::slug($data['shop_name']).'-'.Str::lower(Str::random(6)),
            'description' => $data['shop_description'] ?? null,
            'is_active' => false,
        ]);

        event(new Registered($vendor));

        Auth::login($vendor);

        return redirect()
            ->route('vendor.pending')
            ->with('status', 'Başvurunuz alındı. Hesabınız onaylandığında bilgilendirileceksiniz.');
    }
}
