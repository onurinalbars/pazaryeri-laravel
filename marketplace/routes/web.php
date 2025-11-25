<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Auth\VendorRegistrationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorListingController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorPaymentController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/listings/{slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/shops/{slug}', [ShopController::class, 'show'])->name('shops.show');

/*
|--------------------------------------------------------------------------
| Cart & Checkout
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/{product}', [CartController::class, 'store'])->name('add');
    Route::patch('/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/{product}', [CartController::class, 'destroy'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

/*
|--------------------------------------------------------------------------
| Customer Account
|--------------------------------------------------------------------------
*/
Route::prefix('account')
    ->name('account.')
    ->middleware(['auth', 'user'])
    ->group(function () {
        Route::get('orders', [AccountController::class, 'orders'])->name('orders.index');
        Route::get('orders/{order}', [AccountController::class, 'show'])->name('orders.show');
    });

/*
|--------------------------------------------------------------------------
| Vendor Authentication & Registration
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('vendor/register', [VendorRegistrationController::class, 'create'])->name('vendor.register');
    Route::post('vendor/register', [VendorRegistrationController::class, 'store'])->name('vendor.register.store');
});

/*
|--------------------------------------------------------------------------
| Vendor Panel
|--------------------------------------------------------------------------
*/
Route::prefix('vendor')
    ->name('vendor.')
    ->middleware(['auth', 'vendor'])
    ->group(function () {
        Route::get('dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
        Route::get('pending', fn () => view('vendor.pending'))->name('pending');

        Route::resource('products', VendorProductController::class)->except(['show']);
        Route::resource('listings', VendorListingController::class)->except(['show']);
        Route::resource('orders', VendorOrderController::class)->only(['index', 'show', 'update']);

        Route::get('shop', [VendorShopController::class, 'edit'])->name('shop.edit');
        Route::put('shop', [VendorShopController::class, 'update'])->name('shop.update');
        Route::get('payment', [VendorPaymentController::class, 'edit'])->name('payment.edit');
        Route::put('payment', [VendorPaymentController::class, 'update'])->name('payment.update');
    });

/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('listings', AdminListingController::class)->except(['show']);
        Route::resource('shops', AdminShopController::class)->except(['show']);
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::resource('sliders', AdminSliderController::class)->except(['show']);
        Route::resource('banners', AdminBannerController::class)->except(['show']);

        Route::get('vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
        Route::get('vendors/{vendor}', [AdminVendorController::class, 'show'])->name('vendors.show');
        Route::patch('vendors/{vendor}/status', [AdminVendorController::class, 'updateStatus'])->name('vendors.status');

        Route::get('settings/site', [AdminSettingController::class, 'editSite'])->name('settings.site.edit');
        Route::put('settings/site', [AdminSettingController::class, 'updateSite'])->name('settings.site.update');
        Route::get('settings/payment', [AdminSettingController::class, 'editPayment'])->name('settings.payment.edit');
        Route::put('settings/payment', [AdminSettingController::class, 'updatePayment'])->name('settings.payment.update');
    });

/*
|--------------------------------------------------------------------------
| Authenticated Profile & Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
