<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('invitations/{hash}', [EventController::class, 'getInvitationDetails']);
Route::put('invitations/{hash}', [EventController::class, 'updateInvitationStatus']);
Route::get('lookups/venues', [LookupController::class, 'venues']);
Route::get('lookups/venues/{venue}/services', [LookupController::class, 'services']);
Route::post('bookings', [BookingController::class, 'store']);

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('verify', [AuthController::class, 'verify']);
    Route::post('resend', [AuthController::class, 'resend']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware(['jwt.auth', 'jwt.refresh'])->group(function () {
        Route::any('heartbeat', [AuthController::class, 'heartbeat']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['jwt.auth', 'jwt.refresh'])->group(function () {
    Route::put('account', [UserController::class, 'update']);
    Route::put('account/change-password', [UserController::class, 'changePassword']);

    Route::resource('payment-methods', PaymentMethodController::class);

    Route::get('bookings', [BookingController::class, 'index']);

    Route::prefix('lookups')->group(function () {
        $lookups = [
            'industries',
            'states',
            'genders',
            'weekdays',
            'notifications',
        ];

        foreach ($lookups as $lookup) {
            Route::get($lookup, [LookupController::class, $lookup]);
        }
    });

    Route::resource('contacts', ContactController::class);
    Route::resource('events', EventController::class);
    Route::post('events/{event_id}/invite', [EventController::class, 'invite']);
    Route::put('events/{event_id}/status', [EventController::class, 'changeEventStatus']);
    Route::put('events/{event_id}/cancel', [EventController::class, 'cancelEvent']);

    // Venues
    Route::resource('venues', VenueController::class);

    // Services
    Route::get('venues/{venue_id}/services', [ServiceController::class, 'index']);
    Route::post('venues/{venue_id}/services', [ServiceController::class, 'store']);
    Route::put('venues/{venue_id}/services/{service_id}', [ServiceController::class, 'update']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications', [NotificationController::class, 'add']);
});
