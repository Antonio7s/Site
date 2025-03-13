<?php

use App\Http\Controllers\Auth2\AuthenticatedSessionController2;
use App\Http\Controllers\Auth2\ConfirmablePasswordController2;
use App\Http\Controllers\Auth2\EmailVerificationNotificationController2;
use App\Http\Controllers\Auth2\EmailVerificationPromptController2;
use App\Http\Controllers\Auth2\NewPasswordController2;
use App\Http\Controllers\Auth2\PasswordController2;
use App\Http\Controllers\Auth2\PasswordResetLinkController2;
use App\Http\Controllers\Auth2\RegisteredUserController2;
use App\Http\Controllers\Auth2\VerifyEmailController2;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:clinic')->group(function () {
    Route::get('cadastro-clinica', [RegisteredUserController2::class, 'create'])
        ->name('register2');

    Route::post('register2', [RegisteredUserController2::class, 'store'])->name('register2.store');;

    Route::get('login-clinica', [AuthenticatedSessionController2::class, 'create'])
        ->name('login2');

    Route::post('login-clinica', [AuthenticatedSessionController2::class, 'store']);

    Route::get('forgot-password2', [PasswordResetLinkController2::class, 'create'])
        ->name('password.request2');

    Route::post('forgot-password2', [PasswordResetLinkController2::class, 'store'])
        ->name('password.email2');

    Route::get('reset-password2/{token}', [NewPasswordController2::class, 'create'])
        ->name('password.reset2');

    Route::post('reset-password2', [NewPasswordController2::class, 'store'])
        ->name('password.store2');
});

Route::middleware('auth:clinic')->group(function () {
    // Route::get('verify-email2', EmailVerificationPromptController2::class)
    //     ->name('verification.notice2');

    // Route::get('verify-email2/{id}/{hash}', VerifyEmailController2::class)
    //     ->middleware(['signed', 'throttle:6,1'])
    //     ->name('verification.verify2');

    // Route::post('email/verification-notification2', [EmailVerificationNotificationController2::class, 'store'])
    //     ->middleware('throttle:6,1')
    //     ->name('verification.send2');

    Route::get('confirm-password2', [ConfirmablePasswordController2::class, 'show'])
        ->name('password.confirm2');

    Route::post('confirm-password2', [ConfirmablePasswordController2::class, 'store']);

    Route::put('password2', [PasswordController2::class, 'update'])->name('password.update2');

    Route::post('logout2', [AuthenticatedSessionController2::class, 'destroy'])
        ->name('logout2');
});
