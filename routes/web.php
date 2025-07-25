<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ProductsManager;
use App\Http\Controllers\OrderManager;
use Illuminate\Support\Facades\Route;

//Routes for unauthenticated users
Route::get('/', [ProductsManager::class, 'index'])->name('home');

Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');
Route::get('/product/{slug}', [ProductsManager::class, 'details'])->name('products.details');

//Middleware for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/cart/{id}', [ProductsManager::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ProductsManager::class, 'showCart'])->name('cart.show');
    Route::get('/checkout', [OrderManager::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [OrderManager::class, 'checkoutPost'])->name('checkout.post');
    Route::get('/payment/success/{order_id}', [OrderManager::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/error', [OrderManager::class, 'paymentError'])->name('payment.error');
});
