<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderManager;

Route::any('/stripe/webhook', [OrderManager::class, 'stripeWebhook'])->name('stripe.webhook');
