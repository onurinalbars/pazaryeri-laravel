<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorListingController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorPaymentController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/urun/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/ilan/{slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/magaza/{slug}', [ShopController::class, 'show'])->name('shops.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout & Account
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{order}', [AccountController::class, 'show'])->name('orders.show');
    });
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Vendor panel
Route::middleware(['auth', 'vendor'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/products', VendorProductController::class)->except('show');
        Route::resource('/listings', VendorListingController::class)->except('show');
        Route::get('/shop', [VendorShopController::class, 'edit'])->name('shop.edit');
        Route::post('/shop', [VendorShopController::class, 'update'])->name('shop.update');
        Route::get('/payment-settings', [VendorPaymentController::class, 'edit'])->name('payment.edit');
        Route::post('/payment-settings', [VendorPaymentController::class, 'update'])->name('payment.update');
        Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [VendorOrderController::class, 'update'])->name('orders.update');
    });

// Admin panel
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/categories', AdminCategoryController::class);
        Route::resource('/shops', AdminShopController::class);
        Route::resource('/products', AdminProductController::class);
        Route::resource('/listings', AdminListingController::class);
        Route::resource('/users', AdminUserController::class);
        Route::resource('/sliders', AdminSliderController::class);
        Route::resource('/banners', AdminBannerController::class);
    });
