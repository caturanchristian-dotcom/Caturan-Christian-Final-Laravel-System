<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [MarketplaceController::class, 'home'])->name('home');

Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
Route::get('/about', function () { return view('about'); });
Route::get('/contact', function () { return view('contact'); });

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

Route::middleware(['auth'])->group(function () {
    // Shared Dashboard Redirect
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Account Settings
    Route::get('/profile/settings', [ProfileController::class, 'index'])->name('profile.settings');
    Route::patch('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Real-Time Sync
    Route::get('/api/sync', [NotificationController::class, 'sync'])->name('api.sync');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('api.notif.read');

    // Farmer Routes
    Route::middleware(['role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
        Route::get('/dashboard', [FarmerController::class, 'dashboard'])->name('dashboard');
        Route::get('/products', [FarmerController::class, 'manageProducts'])->name('products.index');
        Route::get('/inventory', [FarmerController::class, 'manageProducts'])->name('inventory');
        Route::post('/products', [FarmerController::class, 'storeProduct'])->name('products.store');
        Route::patch('/products/{product}', [FarmerController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [FarmerController::class, 'deleteProduct'])->name('products.destroy');
        Route::post('/categories', [FarmerController::class, 'storeCategory'])->name('categories.store');
        Route::get('/orders', [FarmerController::class, 'manageOrders'])->name('orders.index');
        Route::patch('/orders/{order}/status', [FarmerController::class, 'updateOrderStatus'])->name('orders.updateStatus');
        Route::get('/reports', [FarmerController::class, 'reports'])->name('reports');
    });

    // Customer Routes
    Route::middleware(['role:customer'])->group(function () {
        Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/marketplace/{product}', [MarketplaceController::class, 'show'])->name('products.show');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/my-orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::delete('/my-orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users.index');
        Route::get('/suppliers/{user}', [AdminController::class, 'viewSupplier'])->name('suppliers.show');
        Route::get('/customers/{user}', [AdminController::class, 'viewCustomer'])->name('customers.show');
        Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::patch('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('users.updateStatus');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
        Route::get('/orders', [AdminController::class, 'monitorOrders'])->name('orders.index');
        Route::get('/inventory', [AdminController::class, 'manageProducts'])->name('products.index');
        Route::delete('/inventory/{product}', [AdminController::class, 'deleteProduct'])->name('products.destroy');
        Route::get('/categories', [AdminController::class, 'manageCategories'])->name('categories.index');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});
