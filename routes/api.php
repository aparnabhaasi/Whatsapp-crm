<?php

use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/whatsapp/callback', [WhatsAppController::class, 'handleCallback']);

Route::get('/whatsapp/callback', [WhatsAppController::class, 'handleCallback']);