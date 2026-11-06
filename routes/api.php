<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\UserController;



/*
|--------------------------------------------------------------------------
| PUBLIC API
|--------------------------------------------------------------------------
*/

Route::post('/login', [
    AuthController::class,
    'login'
]);


// KALENDER PUBLIK
Route::get('/public/events', [
    EventController::class,
    'publicIndex'
]);

Route::post('/forgot-password', [
    AuthController::class,
    'sendOtp'
]);

Route::post('/verify-otp', [
    AuthController::class,
    'verifyOtp'
]);

Route::post('/reset-password', [
    AuthController::class,
    'resetPassword'
]);
/*
|--------------------------------------------------------------------------
| PROTECTED API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */

    Route::get('/me', [
        AuthController::class,
        'me'
    ]);

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);


    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [
        UserController::class,
        'index'
    ]);

    Route::post('/users', [
        UserController::class,
        'store'
    ]);

    Route::get('/users/{user}', [
        UserController::class,
        'show'
    ]);

    Route::put('/users/{user}', [
        UserController::class,
        'update'
    ]);

    Route::delete('/users/{user}', [
        UserController::class,
        'destroy'
    ]);


    /*
    |--------------------------------------------------------------------------
    | ROOMS
    |--------------------------------------------------------------------------
    */

    Route::get('/rooms', [
        RoomController::class,
        'index'
    ]);

    Route::post('/rooms', [
        RoomController::class,
        'store'
    ]);

    Route::get('/rooms/{room}', [
        RoomController::class,
        'show'
    ]);

    Route::put('/rooms/{room}', [
        RoomController::class,
        'update'
    ]);

    Route::delete('/rooms/{room}', [
        RoomController::class,
        'destroy'
    ]);


    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    Route::get('/events', [
        EventController::class,
        'index'
    ]);

    Route::post('/events', [
        EventController::class,
        'store'
    ]);

    Route::get('/events/{event}', [
        EventController::class,
        'show'
    ]);

    Route::put('/events/{event}', [
        EventController::class,
        'update'
    ]);

    Route::delete('/events/{event}', [
        EventController::class,
        'destroy'
    ]);

    Route::put('/events/{event}/status', [
        EventController::class,
        'updateStatus'
    ]);


    /*
    |--------------------------------------------------------------------------
    | COMPLAINTS
    |--------------------------------------------------------------------------
    */

    Route::get('/complaints', [
        ComplaintController::class,
        'index'
    ]);

    Route::post('/complaints', [
        ComplaintController::class,
        'store'
    ]);

    Route::get('/complaints/{complaint}', [
        ComplaintController::class,
        'show'
    ]);

    /*
     * Admin update seluruh data pengaduan.
     */
    Route::put('/complaints/{complaint}', [
        ComplaintController::class,
        'update'
    ]);

    /*
     * Admin menghapus pengaduan.
     */
    Route::delete('/complaints/{complaint}', [
        ComplaintController::class,
        'destroy'
    ]);

    /*
     * PIC hanya memperbarui status dan catatan.
     */
    Route::put('/complaints/{complaint}/status', [
        ComplaintController::class,
        'updateStatus'
    ]);
});