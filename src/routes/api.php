<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\Api\ProductController;

Route::post('payment/callback', [PaymentCallbackController::class, 'callback']);


Route::resource('products', ProductController::class);
