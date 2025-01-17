<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Borrower\BorrowerController;
use App\Http\Controllers\Api\Lender\LenderController;

Route::get('/test', function () {
    return 'Hello, API!';
});

Route::group([ 'prefix' => 'digital-lending'], function () {
    Route::post('registration', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('borrower-information', [BorrowerController::class, 'information']);
    
    Route::post('lender-payment-investment', [LenderController::class, 'paymentInvest']);
    Route::post('lender-investment', [LenderController::class, 'investmentSubmmission']);
    Route::get('lender-information', [LenderController::class, 'information']);

    Route::get('me', [AuthController::class, 'me']);
});

