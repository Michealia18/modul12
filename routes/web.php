<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard (Auth)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Cart & Orders Routes (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Cart
    Route::resource('cart', CartController::class);
    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Product CRUD
    Route::get('/list-product', [ProductController::class, 'search'])->name('products.search');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
});

/*
|--------------------------------------------------------------------------
| Product API by Radius (Public)
|--------------------------------------------------------------------------
*/
Route::get('/products', function (Request $request) {
    $latitude  = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius    = $request->input('radius', 10); // default 10 km

    $products = Product::select('*')
        ->selectRaw(
            "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )
        ->having('distance', '<=', $radius)
        ->orderBy('distance', 'asc')
        ->get();

    return response()->json($products);
});

/*
|--------------------------------------------------------------------------
| Midtrans Callback (No Auth)
|--------------------------------------------------------------------------
*/
Route::post('/payment/midtrans-callback', [PaymentController::class, 'midtransCallback']);

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
