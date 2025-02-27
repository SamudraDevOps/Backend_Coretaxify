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
use App\Http\Controllers\Api\ApiAccountController;
use App\Http\Controllers\Api\ApiContractController;
use App\Http\Controllers\Api\ApiRoleUserController;
use App\Http\Controllers\Api\ApiGroupUserController;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\ApiAssignmentController;
use App\Http\Controllers\Api\ApiUniversityController;
use App\Http\Controllers\Api\ApiAccountTypeController;
use App\Http\Controllers\Api\ApiAlamatWajibPajakController;
use App\Http\Controllers\Api\ApiDataEkonomiController;
use App\Http\Controllers\Api\ApiDetailBankController;
use App\Http\Controllers\Api\ApiDetailKontakController;
use App\Http\Controllers\Api\ApiInformasiUmumController;
use App\Http\Controllers\Api\ApiJenisPajakController;
use App\Http\Controllers\Api\ApiKodeKluController;
use App\Http\Controllers\Api\ApiManajemenKasusController;
use App\Http\Controllers\Api\ApiNomorIdentifikasiEksternalController;
use App\Http\Controllers\Api\ApiObjekPajakBumiDanBangunanController;
use App\Http\Controllers\Api\ApiPenunjukkanWajibPajakSayaController;
use App\Http\Controllers\Api\ApiPihakTerkaitController;
use App\Http\Controllers\Api\ApiPortalSayaController;
use App\Http\Controllers\Api\ApiProfilSayaController;
use App\Http\Controllers\Api\ApiSistemController;

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
            Route::apiResource('accounts', ApiAccountController::class);
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
            Route::apiResource('sistems', ApiSistemController::class);
            Route::apiResource('portal-saya', ApiPortalSayaController::class);
            Route::apiResource('profil-saya', ApiProfilSayaController::class);
            Route::apiResource('informasi-umum', ApiInformasiUmumController::class);
            Route::apiResource('detail-kontak', ApiDetailKontakController::class);
            Route::apiResource('detail-bank', ApiDetailBankController::class);
            Route::apiResource('jenis-pajak', ApiJenisPajakController::class);
            Route::apiResource('kode-klu', ApiKodeKluController::class);
            Route::apiResource('pihak-terkait', ApiPihakTerkaitController::class);
            Route::apiResource('data-ekonomi', ApiDataEkonomiController::class);
            Route::apiResource('objek-pajak-bumi-dan-bangunan', ApiObjekPajakBumiDanBangunanController::class);
            Route::apiResource('nomor-identifikasi-eksternal', ApiNomorIdentifikasiEksternalController::class);
            Route::apiResource('penunjukkan-wajib-pajak-saya', ApiPenunjukkanWajibPajakSayaController::class);
            Route::apiResource('manajemen-kasuses', ApiManajemenKasusController::class);
            Route::apiResource('alamat-wajib-pajak', ApiAlamatWajibPajakController::class);
        });

        Route::prefix('psc')->group(function () {
            // PSC only routes
            Route::apiResource('groups', ApiGroupController::class);
            Route::apiResource('users', ApiUserController::class);
            Route::apiResource('assignments', ApiAssignmentController::class);
            Route::apiResource('exams', ApiExamController::class);
            Route::apiResource('tasks', ApiTaskController::class);
        });

        Route::prefix('student-psc')->group(function () {
            // Student-psc only routes
            Route::apiResource('groups', ApiGroupController::class, ['except' => ['update', 'destroy']]);
            Route::apiResource('assignments', ApiAssignmentController::class, ['except' => ['update', 'destroy']]);
            Route::apiResource('exams', ApiExamController::class, ['except' => ['update', 'destroy']]);
            Route::apiResource('sistems', ApiSistemController::class);
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

        // Route::middleware(['role:mahasiswa-psc'])->prefix('student-psc')->group(function () {
        //     // Student-psc only routes
        //     Route::apiResource('groups', ApiGroupController::class, ['except' => ['update', 'destroy']]);
        //     Route::apiResource('assignments', ApiAssignmentController::class, ['except' => ['update', 'destroy']]);
        //     Route::apiResource('exams', ApiExamController::class, ['except' => ['update', 'destroy']]);
        //     Route::apiResource('sistems', ApiSistemController::class);
        // });

        // Route::middleware(['role:instruktur'])->prefix('instructor')->group(function () {
        //     // Instruktor only routes
        //     Route::apiResource('assignments', ApiAssignmentController::class);
        //     Route::apiResource('users', ApiUserController::class);
        // });
    });
});