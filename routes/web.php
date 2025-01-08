<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

// super admin routes
Route::get('superadmin/login', [SuperadminController::class, 'viewAdminLogin'])->name('superadmin.login');

Route::post('super-admin-login', [SuperadminController::class, 'superAdminLogin']);

Route::post('superadmin/logout', [SuperadminController::class, 'logout'])->name('superadmin.logout');

Route::group(['middleware' => ['auth:superadmin']], function(){
    
    Route::get('superadmin/dashboard', [SuperadminController::class, 'viewDashboard'])->name('superadmin.dashboard');

    Route::get('superadmin/tickets', [TicketsController::class, 'viewSuperadminTickets'])->name('superadmin.tickets');

    Route::post('superadmin/update-payment-status/{id}', [SuperadminController::class, 'updatePaymentStatus']);

    Route::post('/superadmin/update-status', [SuperadminController::class, 'updateStatus'])->name('superadmin.update-status');

    Route::delete('superadmin/delete-user/{id}', [SuperadminController::class, 'deleteUser'])->name('delete-user');
    
    Route::get('superadmin/user-requests', [SuperadminController::class, 'userRequests'])-> name('user-requests');


});

Route::get('privacy-policies', [AdminController::class, 'privacy'])->name('privacy');
Route::get('terms-and-conditions', [AdminController::class, 'terms'])->name('terms');

Route::get('login', [AdminController::class, 'login'])->name('login');

Route::post('admin-login', [AdminController::class, 'adminLogin'])->name('admin-login');

Route::get('register', [AdminController::class, 'viewRegister'])->name('register');

Route::post('app-register', [AdminController::class, 'register'])->name('app.register');

Route::post('logout', [AdminController::class, 'logout'])->name('logout');

// Show the form for requesting a password reset link
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Send the password reset link
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Show the form for resetting the password
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Handle the password reset
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');



Route::middleware(['auth'])->group(function() {

    Route::get('/', [AdminController::class, 'viewDashboard'])->name('/');

    Route::get('/unread-messages-count', [AdminController::class, 'getUnreadMessagesCount']);
    Route::post('/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulkDelete');

    
    Route::resource('broadcast', BroadcastController::class);

    Route::post('broadcast-message', [BroadcastController::class, 'broadcastMessage'])->name('broadcast.message');

    Route::post('update-broadcastGroup/{id}', [BroadcastController::class, 'updateBroadcastGroup'])->name('update.broadcastGruop');

    Route::resource('chat', ChatController::class);

    Route::post('/send-whatsapp-message', [ChatController::class, 'sendMessage'])->name('send.whatsapp.message');

    Route::post('/mark-as-read/{contactId}', [ChatController::class, 'markAsRead']);

    Route::resource('contacts', ContactsController::class);

    Route::post('/upload-contacts', [ContactsController::class, 'uploadContacts'])->name('contacts.upload');
    Route::post('/forward-message', [ChatController::class, 'forwardMessage'])->name('forward.message');



    Route::resource('template', TemplateController::class);

    Route::get('add-template', [TemplateController::class, 'add_template_view'])-> name('template.view');

    Route::post('add-new-template', [TemplateController::class, 'storeTemplate'])->name('template.add');

    Route::get('profile', [AdminController::class, 'showProfile']);

    Route::post('update-profile', [AdminController::class, 'updateProfile'])->name('update.profile');

    Route::post('/password-update', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

    Route::post('update-basics', [AdminController::class, 'updateBasicDetails'])->name('update.basic');

    Route::resource('users', UserController::class);

    Route::post('storeUser', [UserController::class, 'storeUser' ])->name('storeUser');

    Route::post('updateUser/{id}', [UserController::class, 'updateUser'])->name('update.user');

    Route::resource('settings', SettingsController::class);

    Route::resource('tickets', TicketsController::class);

    Route::get('privacy-policy', [AdminController::class, 'view_privacy_policy'])-> name('privacy-policy');

    Route::post('add-tickets', [TicketsController::class, 'storeTickets'])->name('store.tickets');

    Route::post('/tickets/{ticket}/toggle-status', [TicketsController::class, 'toggleStatus'])->name('tickets.toggleStatus');

    Route::delete('superadmin/delete-ticket/{id}', [TicketsController::class, 'deleteTicket'])->name('delete.ticket');
});
