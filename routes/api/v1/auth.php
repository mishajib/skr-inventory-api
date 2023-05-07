<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Auth\{
    LoginController,
    RegisterController
};

Route::post('register', [RegisterController::class, 'store']);
Route::post('login', [LoginController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('current-user', [LoginController::class, 'currentUser']);
    Route::post('refresh-token', [LoginController::class, 'refreshToken']);
    Route::post('logout', [LoginController::class, 'logout']);
});
