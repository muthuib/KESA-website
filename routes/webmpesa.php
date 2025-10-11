<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\MpesaWebhookController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MpesaController;

// ---------------------------
// STK Push (Automatic Payments)
// ---------------------------

// Registration STK Push callback
Route::post('/mpesa/register/callback', [MpesaWebhookController::class, 'registrationCallback'])
    ->name('mpesa.register.callback');

// Membership Renewal STK Push callback
Route::post('/mpesa/stk/callback', [PaymentController::class, 'stkCallback'])
    ->name('mpesa.stk.callback');

// ---------------------------
// Manual Payments (TransactionStatus API)
// ---------------------------

// Manual Registration
Route::post('/mpesa/registration/manual/result', [PaymentController::class, 'manualRegistrationResult'])
    ->name('mpesa.registration.manual.result');

Route::post('/mpesa/registration/manual/timeout', [PaymentController::class, 'manualRegistrationTimeout'])
    ->name('mpesa.registration.manual.timeout');

// Manual Membership Renewal
Route::post('/mpesa/transaction/result', [PaymentController::class, 'transactionResult'])
    ->name('mpesa.transaction.result');

Route::post('/mpesa/transaction/timeout', [PaymentController::class, 'transactionTimeout'])
    ->name('mpesa.transaction.timeout');

// ---------------------------
// Optional C2B Callbacks
// ---------------------------

// Validation and Confirmation
Route::post('/api/mpesa/validation', [MpesaController::class, 'validation']);
Route::post('/api/mpesa/confirmation', [MpesaController::class, 'confirmation']);
