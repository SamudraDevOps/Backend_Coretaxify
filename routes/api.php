<?php

// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiPicController;
use App\Http\Controllers\Api\ApiSptController;
use App\Http\Controllers\Api\ApiExamController;
use App\Http\Controllers\Api\ApiRoleController;
use App\Http\Controllers\Api\ApiTaskController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiBupotController;
use App\Http\Controllers\Api\ApiDummyController;
use App\Http\Controllers\Api\ApiGroupController;
use App\Http\Controllers\Api\ApiFakturController;
use App\Http\Controllers\Api\ApiKapKjsController;
use App\Http\Controllers\Api\ApiSatuanController;
use App\Http\Controllers\Api\ApiSistemController;
use App\Http\Controllers\Api\ApiSptPpnController;
use App\Http\Controllers\Api\ApiAccountController;
use App\Http\Controllers\Api\ApiContractController;
use App\Http\Controllers\Api\ApiRoleUserController;
use App\Http\Controllers\Api\ApiGroupUserController;
use App\Http\Controllers\Api\ApiWakilSayaController;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\ApiAssignmentController;
use App\Http\Controllers\Api\ApiDetailBankController;
use App\Http\Controllers\Api\ApiJenisPajakController;
use App\Http\Controllers\Api\ApiPembayaranController;
use App\Http\Controllers\Api\ApiProfilSayaController;
use App\Http\Controllers\Api\ApiUniversityController;
use App\Http\Controllers\Api\ApiAccountTypeController;
use App\Http\Controllers\Api\ApiDataEkonomiController;
use App\Http\Controllers\Api\ApiDetailKontakController;
use App\Http\Controllers\Api\ApiPihakTerkaitController;
use App\Http\Controllers\Api\ApiInformasiUmumController;
use App\Http\Controllers\Api\ApiKodeTransaksiController;
use App\Http\Controllers\Api\ApiAssignmentUserController;
use App\Http\Controllers\Api\ApiManajemenKasusController;
use App\Http\Controllers\Api\ApiSistemTambahanController;
use App\Http\Controllers\Api\ApiBupotObjekPajakController;
use App\Http\Controllers\Api\ApiDetailTransaksiController;
use App\Http\Controllers\Api\ApiInformasiTambahanController;
use App\Http\Controllers\Api\ApiUnitPajakKeluargaController;
use App\Http\Controllers\Api\ApiTempatKegiatanUsahaController;
use App\Http\Controllers\Api\ApiObjekPajakBumiDanBangunanController;
use App\Http\Controllers\Api\ApiPenunjukkanWajibPajakSayaController;
use App\Http\Controllers\Api\ApiNomorIdentifikasiEksternalController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::prefix('auth')->group(function () {
//     Route::post('login', [ApiAuthController::class, 'login']);
//     Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
// });

Route::get('routes/download', function () {
    $routeCollection = Route::getRoutes();
    $routes = [];

    foreach ($routeCollection as $route) {
        $routes[] = [
            'method' => isset($route->methods()[0]) ? $route->methods()[0] : '',
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    }

    // Create JavaScript content
    $jsContent = "// Laravel Routes Export\n";
    $jsContent .= "const routes = " . json_encode($routes, JSON_PRETTY_PRINT) . ";\n\n";
    $jsContent .= "// Example function to find route by name\n";
    $jsContent .= "function findRouteByName(name) {\n";
    $jsContent .= "  return routes.find(route => route.name === name);\n";
    $jsContent .= "}\n\n";
    $jsContent .= "// Example function to find routes by method\n";
    $jsContent .= "function findRoutesByMethod(method) {\n";
    $jsContent .= "  return routes.filter(route => route.method.toUpperCase() === method.toUpperCase());\n";
    $jsContent .= "}\n";

    // Return as downloadable JavaScript file
    return response($jsContent)
        ->header('Content-Type', 'application/javascript')
        ->header('Content-Disposition', 'attachment; filename="laravel-routes.js"');
});

Route::get('/csrf-token', function (Request $request) {
    return response()->json(['token' => csrf_token()]);
})->middleware('web');

Route::group(['middleware' => ['api'], 'as' => 'api.'], function () {
    Route::get('kode-transaksi', [ApiKodeTransaksiController::class, 'index']);
    Route::get('satuan', [ApiSatuanController::class, 'index']);
    Route::get('kap-kjs', [ApiKapKjsController::class, 'index']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/reset-password', [ApiAuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::get('/profile', [ApiAuthController::class, 'me']);
        Route::post('/profile/update', [ApiAuthController::class, 'updateProfile']);
        Route::post('/verify-otp', [ApiAuthController::class, 'verifyOtp']);
        Route::post('/resend-otp', [ApiAuthController::class, 'resendOtp']);
        Route::get('/verification-status', [ApiAuthController::class, 'verificationStatus']);
        Route::apiResource('bupot-objek-pajaks', ApiBupotObjekPajakController::class);

        Route::middleware('verified')->group(function () {
            Route::prefix('admin')->group(function () {
                // Admin only routes
                Route::apiResource('users', ApiUserController::class);
                Route::apiResource('accounts', ApiAccountController::class);
                Route::apiResource('assignments', ApiAssignmentController::class);
                Route::prefix('assignments')->group(function () {
                    Route::get('{assignment}/members', [ApiAssignmentController::class, 'getMembers']);
                });
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
                Route::prefix('groups')->group(function () {
                    Route::get('{group}/members', [ApiGroupController::class, 'getMembers']);
                    Route::delete('{group}/members/{user}', [ApiGroupController::class, 'removeMember']);
                    Route::get('{group}/members/{user}', [ApiGroupController::class, 'getMemberDetail']);

                    Route::get('{group}/assignments', [ApiGroupController::class, 'getAssignments']);
                    Route::get('{group}/assignments/{assignment}', [ApiGroupController::class, 'showAssignment']);
                    Route::post('{group}/assignments', [ApiGroupController::class, 'storeAssignment']);
                    Route::put('{group}/assignments/{assignment}', [ApiGroupController::class, 'updateAssignment']);
                    Route::delete('{group}/assignments/{assignment}', [ApiGroupController::class, 'removeAssignment']);

                    Route::get('{group}/assignments/{assignment}/members', [ApiGroupController::class, 'getAssignmentMembers']);
                    Route::delete('{group}/assignments/{assignment}/members/{user}', [ApiGroupController::class, 'removeAssignmentMember']);
                    Route::get('{group}/assignments/{assignment}/members/{user}', [ApiGroupController::class, 'getAssignmentMemberDetail']);
                });
                Route::apiResource('assignments', ApiAssignmentController::class);
                Route::prefix('assignments')->group(function () {
                    Route::get('{assignment}/members', [ApiAssignmentController::class, 'getMembers']);
                    Route::delete('{assignment}/members/{user}', [ApiAssignmentController::class, 'removeMember']);
                    Route::get('{assignment}/members/{user}', [ApiAssignmentController::class, 'getMemberDetail']);
                });
                Route::apiResource('exams', ApiExamController::class);
                Route::prefix('exams')->group(function () {
                    Route::get('{exam}/members', [ApiExamController::class, 'getMembers']);
                    Route::delete('{exam}/members/{user}', [ApiExamController::class, 'removeMember']);
                    Route::get('{exam}/members/{user}', [ApiExamController::class, 'getMemberDetail']);
                });
                Route::apiResource('group-users', ApiGroupUserController::class);
                Route::get('contract-tasks', [ApiTaskController::class, 'getContractTasks']);
            });

            Route::prefix('student')->group(function () {
                // Student only routes;
                Route::apiResource('groups', ApiGroupController::class, ['except' => ['update', 'destroy']]);
                Route::apiResource('assignments', ApiAssignmentController::class, ['except' => ['update', 'destroy']]);
                Route::apiResource('assignment-user', ApiAssignmentUserController::class);
                Route::apiResource('exams', ApiExamController::class, ['except' => ['update', 'destroy']]);

                Route::prefix('assignments')->group(function () {
                    Route::get('{assignment}/sistem', [ApiSistemController::class, 'getSistems']);
                    Route::get('{assignment}/sistem/{sistem}', [ApiSistemController::class, 'getSistemDetail']);

                    Route::post('{assignment}/sistem/{sistem}/pihak-terkait', [ApiPihakTerkaitController::class, 'store']);
                    Route::get('{assignment}/sistem/{sistem}/pihak-terkait', [ApiPihakTerkaitController::class, 'index']);
                    Route::delete('{assignment}/sistem/{sistem}/pihak-terkait/{pihakTerkait}', [ApiPihakTerkaitController::class, 'destroy']);

                    Route::get('{assignment}/sistem/{sistem}/data-ekonomi/{dataEkonomi}', [ApiDataEkonomiController::class, 'show']);
                    Route::put('{assignment}/sistem/{sistem}/data-ekonomi/{dataEkonomi}', [ApiDataEkonomiController::class, 'update']); //harusegapake wkwk

                    Route::get('{assignment}/sistem/{sistem}/informasi-umum', [ApiSistemController::class, 'getSistemDetail']);
                    Route::get('{assignment}/sistem/{sistem}/informasi-umum/{informasiUmum}', [ApiInformasiUmumController::class, 'show']);
                    Route::put('{assignment}/sistem/{sistem}/informasi-umum/{informasiUmum}', [ApiInformasiUmumController::class, 'update']); //harusegapake wkwk

                    Route::get('{assignment}/sistem/{sistem}/detail-kontak', [ApiDetailKontakController::class, 'index']);
                    Route::post('{assignment}/sistem/{sistem}/detail-kontak', [ApiDetailKontakController::class, 'store']);
                    Route::get('{assignment}/sistem/{sistem}/detail-kontak/{detailKontak}', [ApiDetailKontakController::class, 'show']);
                    Route::put('{assignment}/sistem/{sistem}/detail-kontak/{detailKontak}', [ApiDetailKontakController::class, 'update']);
                    Route::delete('{assignment}/sistem/{sistem}/detail-kontak/{detailKontak}', [ApiDetailKontakController::class, 'destroy']);

                    Route::get('{assignment}/sistem/{sistem}/tempat-kegiatan-usaha', [ApiTempatKegiatanUsahaController::class, 'index']);
                    Route::post('{assignment}/sistem/{sistem}/tempat-kegiatan-usaha', [ApiTempatKegiatanUsahaController::class, 'store']);
                    Route::get('{assignment}/sistem/{sistem}/tempat-kegiatan-usaha/{tempatKegiatanUsaha}', [ApiTempatKegiatanUsahaController::class, 'show']);
                    Route::put('{assignment}/sistem/{sistem}/tempat-kegiatan-usaha/{tempatKegiatanUsaha}', [ApiTempatKegiatanUsahaController::class, 'update']);
                    Route::delete('{assignment}/sistem/{sistem}/tempat-kegiatan-usaha/{tempatKegiatanUsaha}', [ApiTempatKegiatanUsahaController::class, 'destroy']);

                    Route::get('{assignment}/sistem/{sistem}/detail-bank', [ApiDetailBankController::class, 'index']);
                    Route::post('{assignment}/sistem/{sistem}/detail-bank', [ApiDetailBankController::class, 'store']);
                    Route::get('{assignment}/sistem/{sistem}/detail-bank/{detailBank}', [ApiDetailBankController::class, 'show']);
                    Route::put('{assignment}/sistem/{sistem}/detail-bank/{detailBank}', [ApiDetailBankController::class, 'update']);
                    Route::delete('{assignment}/sistem/{sistem}/detail-bank/{detailBank}', [ApiDetailBankController::class, 'destroy']);

                    Route::get('{assignment}/sistem/{sistem}/unit-pajak-keluarga', [ApiUnitPajakKeluargaController::class, 'index']);
                    Route::post('{assignment}/sistem/{sistem}/unit-pajak-keluarga', [ApiUnitPajakKeluargaController::class, 'store']);
                    Route::get('{assignment}/sistem/{sistem}/unit-pajak-keluarga/{unitPajakKeluarga}', [ApiUnitPajakKeluargaController::class, 'show']);
                    Route::put('{assignment}/sistem/{sistem}/unit-pajak-keluarga/{unitPajakKeluarga}', [ApiUnitPajakKeluargaController::class, 'update']);
                    Route::delete('{assignment}/sistem/{sistem}/unit-pajak-keluarga/{unitPajakKeluarga}', [ApiUnitPajakKeluargaController::class, 'destroy']);

                    Route::put('{assignment}/sistem/{sistem}/nomor-identifikasi-eksternal', [ApiNomorIdentifikasiEksternalController::class, 'update']);

                    Route::prefix('faktur')->group(function () {
                        Route::apiResource('kode-transaksi', ApiKodeTransaksiController::class, ['only' => ['index']]);
                        Route::apiResource('informasi-tambahan', ApiInformasiTambahanController::class, ['only' => ['index']]);
                        Route::apiResource('satuan', ApiSatuanController::class, ['only' => ['index']]);
                    });

                    // Route::put('{assignment}/sistem/{sistem}/faktur/{faktur}', [ApiFakturController::class, 'update'])->middleware('account.representation'); // must representing company
                    // Route::post('{assignment}/sistem/{sistem}/faktur', [ApiFakturController::class, 'store'])->middleware('account.representation'); // must representing company
                    Route::get('{assignment}/sistem/{sistem}/faktur', [ApiFakturController::class, 'index']);
                    Route::get('{assignment}/sistem/{sistem}/faktur/{faktur}', [ApiFakturController::class, 'show']);
                    Route::post('{assignment}/sistem/{sistem}/faktur', [ApiFakturController::class, 'store']);
                    Route::put('{assignment}/sistem/{sistem}/faktur/{faktur}', [ApiFakturController::class, 'update']);
                    Route::delete('{assignment}/sistem/{sistem}/faktur/{faktur}', [ApiFakturController::class, 'destroy']);
                    Route::get('{assignment}/sistem/{sistem}/getAkun', [ApiFakturController::class, 'getCombinedAkunData']);

                    Route::post('{assignment}/sistem/{sistem}/faktur/delete-multiple', [ApiFakturController::class, 'deleteMultipleFakturs']);
                    Route::post('{assignment}/sistem/{sistem}/faktur/approve-multiple', [ApiFakturController::class, 'multipleDraftFakturToFix']);
                    Route::post('{assignment}/sistem/{sistem}/faktur/kreditkan-multiple', [ApiFakturController::class, 'multipleKreditkanFakturs']);
                    Route::post('{assignment}/sistem/{sistem}/faktur/unkreditkan-multiple', [ApiFakturController::class, 'multipleUnkreditkanFakturs']);

                    // Route::post('{assignment}/sistem/{sistem}/faktur/{faktur}/detail-transaksi', [ApiFakturController::class, 'addDetailTransaksi']);
                    // Route::delete('{assignment}/sistem/{sistem}/faktur/{faktur}/detail-transaksi/{detailTransaksi}', [ApiFakturController::class, 'deleteDetailTransaksi']);

                    Route::apiResource('{assignment}/sistem/{sistem}/sistem-tambahan', ApiSistemTambahanController::class);

                    Route::apiResource('{assignment}/sistem/{sistem}/faktur/{faktur}/detail-transaksi', ApiDetailTransaksiController::class);

                    Route::get('{assignment}/sistem/{sistem}/check-periode', [ApiSptController::class, 'checkPeriode']);
                    Route::put('{assignment}/sistem/{sistem}/spt/{spt}/calculate-spt', [ApiSptController::class, 'calculateSpt']);
                    Route::apiResource('{assignment}/sistem/{sistem}/spt', ApiSptController::class);
                    Route::get('{assignment}/sistem/{sistem}/spt/{spt}/show-faktur-ppn', [ApiSptController::class, 'showFakturSptPpn']);
                    Route::get('{assignment}/sistem/{sistem}/spt/{spt}/show-bupot-pph', [ApiSptController::class, 'showBupotSptPph']);
                    Route::get('{assignment}/sistem/{sistem}/spt/{spt}/show-bupot-pph-unifikasi', [ApiSptController::class, 'showBupotSptPphUnifikasi']);

                    Route::apiResource('{assignment}/sistem/{sistem}/pembayaran', ApiPembayaranController::class);
                    Route::apiResource('{assignment}/sistem/{sistem}/spt-ppn', ApiSptPpnController::class);

                    // BUPOT
                    // menampilkan objek pajak udah ada di luar
                    // menampilkan bupot by jenis. ditambah intent, misal api.bupot.bppu
                    Route::apiResource('{assignment}/sistem/{sistem}/bupot', ApiBupotController::class);
                    Route::post('{assignment}/sistem/{sistem}/bupot/approval', [ApiBupotController::class, 'penerbitan']);
                    Route::post('{assignment}/sistem/{sistem}/bupot/refusal', [ApiBupotController::class, 'penghapusan']);

                    // Representation management
                    Route::get('{assignment}/sistem/{sistem}/represented-companies', [ApiPicController::class, 'getRepresentedCompanies']); // get list of companies that can be represented
                    Route::get('{assignment}/sistem/{sistem}/representatives', [ApiPicController::class, 'getCompanyRepresentatives']); // get list of company's representatives
                    Route::post('{assignment}/sistem/{sistem}/representatives', [ApiPicController::class, 'assignRepresentative']);
                    // Route::delete('{assignment}/sistem/{sistem}/representatives/{personalId}', [ApiPicController::class, 'removeRepresentative']);
                    Route::post('{assignment}/sistem/{sistem}/check-representation', [ApiPicController::class, 'checkRepresentation']); // check is this account can represent selected company
                });

                Route::apiResource('sistem', ApiSistemController::class);
                Route::apiResource('profil-saya', ApiProfilSayaController::class);
                Route::apiResource('informasi-umum', ApiInformasiUmumController::class);
                Route::apiResource('detail-kontak', ApiDetailKontakController::class);
                Route::apiResource('detail-bank', ApiDetailBankController::class);
                Route::apiResource('pihak-terkait', ApiPihakTerkaitController::class);
                Route::apiResource('data-ekonomi', ApiDataEkonomiController::class);
                Route::apiResource('nomor-identifikasi-eksternal', ApiNomorIdentifikasiEksternalController::class);
                // Route::apiResource('penunjukkan-wajib-pajak-saya', ApiPenunjukkanWajibPajakSayaController::class);
            });

            Route::prefix('psc')->group(function () {
                // PSC only routes
                Route::apiResource('groups', ApiGroupController::class);
                Route::prefix('groups')->group(function () {
                    Route::get('{group}/members', [ApiGroupController::class, 'getMembers']);
                    Route::delete('{group}/members/{user}', [ApiGroupController::class, 'removeMember']);
                    Route::get('{group}/members/{user}', [ApiGroupController::class, 'getMemberDetail']);
                });
                Route::apiResource('users', ApiUserController::class);
                Route::apiResource('assignments', ApiAssignmentController::class);
                Route::prefix('assignments')->group(function () {
                    Route::get('{assignment}/members', [ApiAssignmentController::class, 'getMembers']);
                    Route::delete('{assignment}/members/{user}', [ApiAssignmentController::class, 'removeMember']);
                    Route::get('{assignment}/members/{user}', [ApiAssignmentController::class, 'getMemberDetail']);
                });
                Route::apiResource('exams', ApiExamController::class);
                Route::prefix('exams')->group(function () {
                    Route::get('{exam}/members', [ApiExamController::class, 'getMembers']);
                    Route::delete('{exam}/members/{user}', [ApiExamController::class, 'removeMember']);
                    Route::get('{exam}/members/{user}', [ApiExamController::class, 'getMemberDetail']);
                });
                // Route::prefix('evaluations')->group(function () {
                //     Route::get('{exam}/members', [ApiExamController::class, 'getMembers']);
                //     Route::delete('{exam}/members/{user}', [ApiExamController::class, 'removeMember']);
                //     Route::get('{exam}/members/{user}', [ApiExamController::class, 'getMemberDetail']);
                // });
                Route::apiResource('tasks', ApiTaskController::class);
            });

            Route::prefix('student-psc')->group(function () {
                // Student-psc only routes
                Route::apiResource('groups', ApiGroupController::class, ['except' => ['update', 'destroy']]);
                Route::prefix('groups')->group(function () {
                    Route::get('{group}/assignments', [ApiGroupController::class, 'getAssignments']);
                });
                Route::apiResource('assignments', ApiAssignmentController::class, ['except' => ['update', 'destroy']]);
                Route::apiResource('exams', ApiExamController::class, ['except' => ['update', 'destroy']]);
                Route::apiResource('sistems', ApiSistemController::class);
            });

            Route::prefix('instructor')->group(function () {
                // Instruktor only routes
                Route::apiResource('tasks', ApiTaskController::class, ['only' => ['index', 'show']]);
                Route::apiResource('assignments', ApiAssignmentController::class);
                // Route::apiResource('users', ApiUserController::class);
            });
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
