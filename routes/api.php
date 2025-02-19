<?php

// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiExamController;
use App\Http\Controllers\Api\ApiRoleController;
use App\Http\Controllers\Api\ApiTaskController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiDummyController;
use App\Http\Controllers\Api\ApiGroupController;
use App\Http\Controllers\Api\ApiContractController;
use App\Http\Controllers\Api\ApiRoleUserController;
use App\Http\Controllers\Api\ApiGroupUserController;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\ApiAssignmentController;
use App\Http\Controllers\Api\ApiUniversityController;
use App\Http\Controllers\Api\ApiAccountTypeController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::prefix('auth')->group(function () {
//     Route::post('login', [ApiAuthController::class, 'login']);
//     Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
// });
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, X-XSRF-TOKEN');
header('Access-Control-Allow-Credentials: true');

Route::get('/csrf-token', function (Request $request) {
    return response()->json(['token' => csrf_token()]);
})->middleware('web');

Route::group(['middleware' => ['api'], 'as' => 'api.'], function () {
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [ApiAuthController::class, 'resendOtp']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/reset-password', [ApiAuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/profile', [ApiAuthController::class, 'me']);
        Route::post('/profile/update', [ApiAuthController::class, 'updateProfile']);

        Route::prefix('admin')->group(function () {
            // Admin only routes
            Route::apiResource('users', ApiUserController::class);
            Route::apiResource('groups', ApiGroupController::class);
            Route::apiResource('roles', ApiRoleController::class);
            Route::apiResource('tasks', ApiTaskController::class);
            Route::apiResource('universities', ApiUniversityController::class);
            Route::apiResource('contract', ApiContractController::class);
            Route::apiResource('account-types', ApiAccountTypeController::class);
        });

        Route::prefix('lecturer')->group(function () {
            // Lecturer only routes
            Route::apiResource('groups', ApiGroupController::class);
            Route::apiResource('assignments', ApiAssignmentController::class);
            Route::apiResource('exams', ApiExamController::class);
            Route::apiResource('group-users', ApiGroupUserController::class);
            Route::get('contract-tasks', [ApiTaskController::class, 'getContractTasks']);
        });

        Route::prefix('student')->group(function () {
            // Student only routes
            Route::apiResource('groups', ApiGroupController::class, ['except' => ['update', 'destroy']]);
            Route::apiResource('assignments', ApiAssignmentController::class, ['except' => ['update', 'destroy']]);
            Route::apiResource('exams', ApiExamController::class, ['except' => ['update', 'destroy']]);
        });

        Route::prefix('psc')->group(function () {
            // PSC only routes
            Route::apiResource('groups', ApiGroupController::class);
            Route::apiResource('users', ApiUserController::class);
            Route::apiResource('assignments', ApiAssignmentController::class);
            Route::apiResource('exams', ApiExamController::class);
            Route::apiResource('tasks', ApiTaskController::class);
        });

        Route::prefix('instructor')->group(function () {
            // Instruktor only routes
            Route::apiResource('assignments', ApiAssignmentController::class);
            Route::apiResource('users', ApiUserController::class);
        });

        // Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        //     // Admin only routes
        //     Route::apiResource('users', ApiUserController::class);
        //     Route::apiResource('groups', ApiGroupController::class);
        //     Route::apiResource('roles', ApiRoleController::class);
        //     Route::apiResource('tasks', ApiTaskController::class);
        //     Route::apiResource('universities', ApiUniversityController::class);
        //     Route::apiResource('contract', ApiContractController::class);
        //     Route::apiResource('account-types', ApiAccountTypeController::class);
        // });

        // Route::middleware(['role:dosen'])->prefix('lecturer')->group(function () {
        //     // Lecturer only routes
        //     Route::apiResource('groups', ApiGroupController::class);
        //     Route::apiResource('assignments', ApiAssignmentController::class);
        //     Route::apiResource('exams', ApiExamController::class);
        //     Route::apiResource('group-users', ApiGroupUserController::class);
        // });

        // Route::middleware(['role:mahasiswa'])->prefix('student')->group(function () {
        //     // Student only routes
        //     Route::resource('groups', ApiGroupController::class, ['only' => ['store']]);
        //     Route::resource('lecture-tasks', ApiAssignmentController::class, ['only' => ['store']]);
        // });

        // Route::middleware(['role:psc'])->prefix('psc')->group(function () {
        //     // PSC only routes
        //     Route::apiResource('groups', ApiGroupController::class);
        //     Route::apiResource('users', ApiUserController::class);
        //     Route::apiResource('assignments', ApiAssignmentController::class);
        //     Route::apiResource('exams', ApiExamController::class);
        // });

        // Route::middleware(['role:instruktur'])->prefix('instructor')->group(function () {
        //     // Instruktor only routes
        //     Route::apiResource('assignments', ApiAssignmentController::class);
        //     Route::apiResource('users', ApiUserController::class);
        // });
    });
});
