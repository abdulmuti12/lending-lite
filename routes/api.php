<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\AuthController;

Route::get('/test', function () {
    return 'Hello, API!';
});

Route::group([ 'prefix' => 'digital-lending'], function () {
    Route::post('registration', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('me', [AuthController::class, 'me']);
});

