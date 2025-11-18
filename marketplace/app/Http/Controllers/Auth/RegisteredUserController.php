<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'register_as_vendor' => ['nullable', 'boolean'],
            'shop_name' => ['nullable', 'string', 'max:255'],
        ]);

        $role = ! empty($validated['register_as_vendor']) ? 'vendor' : 'customer';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        if ($role === 'vendor') {
            $shopName = $validated['shop_name'] ?: "{$user->name} Shop";

            Shop::create([
                'user_id' => $user->id,
                'name' => $shopName,
                'slug' => Str::slug($shopName).'-'.Str::lower(Str::random(4)),
                'description' => null,
                'is_active' => false,
            ]);
        }

        Auth::login($user);

        return redirect()->intended(route('home'))->with('success', 'Welcome aboard!');
    }
}
