<?php

// use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiDummyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\ApiRoleUserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::prefix('auth')->group(function () {
//     Route::post('login', [ApiAuthController::class, 'login']);
//     Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
// });

Route::group(['as' => 'api.'], function () {
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/me', [ApiAuthController::class, 'me']);
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/admin', [ApiDummyController::class, 'index']);
    });

    Route::middleware(['auth:sanctum', 'role:dosen'])->group(function () {
        // Lecturer only routes
    });

    Route::middleware(['auth:sanctum', 'role:mahasiswa'])->group(function () {
        // Student only routes
    });

    Route::middleware(['auth:sanctum', 'role:psc'])->group(function () {
        // PSC only routes
    });
});



