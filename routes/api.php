<?php

use App\Http\Controllers\MidtransWebhookController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])
//     ->withoutMiddleware([VerifyCsrfToken::class]);