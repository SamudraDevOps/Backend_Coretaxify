<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiRoleController;
use App\Http\Controllers\Api\ApiTaskController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiDummyController;
use App\Http\Controllers\Api\ApiGroupController;
use App\Http\Controllers\Api\ApiGroupUserController;
use App\Http\Controllers\Api\ApiContractController;
use App\Http\Controllers\Api\ApiRoleUserController;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\ApiLectureTaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::prefix('auth')->group(function () {
//     Route::post('login', [ApiAuthController::class, 'login']);
//     Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
// });

Route::group(['middleware' => ['api'], 'as' => 'api.'], function () {
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/me', [ApiAuthController::class, 'me']);
    });

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/admin', [ApiDummyController::class, 'index']);
        Route::resource('users', ApiUserController::class) ;
        Route::resource('groups', ApiGroupController::class);
        // Route::resource('contracts', ApiContractController::class);
        Route::resource('roles', ApiRoleController::class);
        Route::resource('tasks', ApiTaskController::class);
        Route::resource('universities', ApiUserController::class);
        // Admin only routes
        Route::apiResource('contract', ApiContractController::class);
    });

    Route::middleware(['auth:sanctum', 'role:dosen'])->group(function () {
        // Lecturer only routes
        Route::resource('groups', ApiGroupController::class);
        Route::resource('lecture-tasks', ApiLectureTaskController::class);
        Route::resource('group-users', ApiGroupUserController::class);
    });

    Route::middleware(['auth:sanctum', 'role:mahasiswa'])->group(function () {
        // Student only routes
    });

    Route::middleware(['auth:sanctum', 'role:psc'])->group(function () {
        // PSC only routes
    });
});