<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front-end.index');
});


// Route::post('/whatsapp/callback', [WhatsAppController::class, 'handleCallback']);

// Route::get('/whatsapp/callback', [WhatsAppController::class, 'handleCallback']);
 
Route::resource('broadcast', BroadcastController::class);

Route::post('broadcast-message', [BroadcastController::class, 'broadcastMessage'])->name('broadcast.message');

Route::resource('chat', ChatController::class);

Route::resource('contacts', ContactsController::class);

Route::resource('template', TemplateController::class);

Route::get('add-template', [TemplateController::class, 'add_template_view'])-> name('template.view');

Route::resource('profile', AdminController::class);

Route::resource('users', UserController::class);

Route::resource('settings', SettingsController::class);

Route::resource('tickets', TicketsController::class);

Route::get('privacy-policy', [AdminController::class, 'view_privacy_policy'])-> name('privacy-policy');

