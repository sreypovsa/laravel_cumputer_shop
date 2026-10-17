<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes (Nevixra Template)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Payment (ABA, ACLEDA, Wing KHQR)
Route::get('/payment/{order_number}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{order_number}/upload-slip', [PaymentController::class, 'uploadSlip'])->name('payment.upload-slip');
Route::get('/order-success/{order_number}', [PaymentController::class, 'success'])->name('order.success');

// Order Tracking
Route::get('/track-order', [TrackingController::class, 'index'])->name('track.order');
Route::get('/track-order/{code}', [TrackingController::class, 'show'])->name('track.order.code');

// Customer Accounts
Route::middleware('guest')->group(function () {
    Route::get('/login', [AccountController::class, 'showLogin'])->name('login');
    Route::post('/login', [AccountController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');
    Route::get('/register', [AccountController::class, 'showRegister'])->name('register');
    Route::post('/register', [AccountController::class, 'register'])->middleware('throttle:6,1')->name('register.submit');
});

Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('account.index');
    Route::get('/orders/{order_number}', [AccountController::class, 'showOrder'])->name('account.order');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::put('/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
});
Route::post('/logout', [AccountController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (Osen Admin Template)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // Guest Admin Auth
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // Orders Management
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::get('/orders/{id}/invoice', [AdminOrderController::class, 'invoice'])->name('admin.orders.invoice');
        Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
        Route::post('/orders/{id}/confirm', [AdminOrderController::class, 'quickConfirm'])->name('admin.orders.confirm');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

        // Products Management
        Route::post('/products/{id}/duplicate', [AdminProductController::class, 'duplicate'])->name('admin.products.duplicate');
        Route::resource('products', AdminProductController::class)->names('admin.products');

        // Categories Management
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // Brands Management
        Route::get('/brands', [AdminBrandController::class, 'index'])->name('admin.brands.index');
        Route::post('/brands', [AdminBrandController::class, 'store'])->name('admin.brands.store');
        Route::put('/brands/{id}', [AdminBrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('/brands/{id}', [AdminBrandController::class, 'destroy'])->name('admin.brands.destroy');

        // Customers Management
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/customers/{phone}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');

        // Invoices Management
        Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('admin.invoices.index');
        Route::get('/invoices/{id}', [AdminInvoiceController::class, 'show'])->name('admin.invoices.show');

        // Store Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    });
});
