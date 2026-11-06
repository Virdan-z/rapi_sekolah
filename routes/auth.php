<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\OtpPasswordResetController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);


    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);


    /*
    |--------------------------------------------------------------------------
    | LUPA PASSWORD - KIRIM OTP
    |--------------------------------------------------------------------------
    */

    Route::get('/forgot-password', [OtpPasswordResetController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [OtpPasswordResetController::class, 'sendOtp'])
        ->middleware('throttle:3,1')
        ->name('password.email');


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI OTP
    |--------------------------------------------------------------------------
    */

    Route::get('/verify-otp', [OtpPasswordResetController::class, 'showVerifyOtp'])
        ->name('password.otp.form');

    Route::post('/verify-otp', [OtpPasswordResetController::class, 'verifyOtp'])
        ->middleware('throttle:10,1')
        ->name('password.otp.verify');


    /*
    |--------------------------------------------------------------------------
    | PASSWORD BARU
    |--------------------------------------------------------------------------
    */

    Route::get('/reset-password', [OtpPasswordResetController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [OtpPasswordResetController::class, 'resetPassword'])
        ->middleware('throttle:5,1')
        ->name('password.store');

});


/*
|--------------------------------------------------------------------------
| ROUTE AUTHENTIKASI PENGGUNA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

});