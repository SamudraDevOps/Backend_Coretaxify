<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssignmentUser;
use App\Models\Sistem;
use App\Services\StudentMonitoringService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiMonitoringController extends Controller
{
    protected $monitoringService;

    public function __construct(StudentMonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    public function getStudentsForMonitoring(Request $request): JsonResponse
    {
        $user = auth()->user();

        // Check permissions
        if (!$user->hasRole('dosen') && !$user->hasRole('psc')) {
            return response()->json(['error' => 'Only dosen and PSC can monitor students'], 403);
        }

        try {
            $students = $this->monitoringService->getStudentsForMonitoring($user);

            return response()->json([
                'data' => $students,
                'count' => $students->count(),
                'supervisor_role' => $user->roles->first()->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get students for monitoring',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getStudentSimulationDetail(AssignmentUser $assignmentUser): JsonResponse
    {
        $user = auth()->user();

        try {
            $simulationDetail = $this->monitoringService->getStudentSimulationDetail($assignmentUser, $user);

            return response()->json($simulationDetail);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get student simulation detail',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function getSistemForMonitoring(Sistem $sistem): JsonResponse
    {
        $user = auth()->user();

        try {
            $sistemDetail = $this->monitoringService->getSistemForMonitoring($sistem, $user);

            return response()->json($sistemDetail);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get sistem for monitoring',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function getGroupOverview(Request $request): JsonResponse
    {
        $user = auth()->user();

        if (!$user->hasRole('dosen') && !$user->hasRole('psc')) {
            return response()->json(['error' => 'Only dosen and PSC can view group overview'], 403);
        }

        try {
            $overview = $this->monitoringService->getGroupOverview($user);

            return response()->json([
                'data' => $overview,
                'count' => count($overview)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get group overview',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Special monitoring routes that mirror student routes but in read-only mode
    public function monitorSistemDetail(Request $request, AssignmentUser $assignmentUser, Sistem $sistem): JsonResponse
    {
        $user = auth()->user();

        try {
            // Verify monitoring permissions
            $this->monitoringService->getSistemForMonitoring($sistem, $user);

            // Get the same data as student would see, but mark as monitoring mode
            $sistem->load([
                'profil_saya.informasi_umum',
                'profil_saya.data_ekonomi',
                'profil_saya.nomor_identifikasi_eksternal',
                'detail_kontaks',
                'tempat_kegiatan_usahas',
                'detail_banks',
                'unit_pajak_keluargas',
                'pihak_terkaits',
                'sistem_tambahans'
            ]);

            return response()->json([
                'sistem' => $sistem,
                'is_monitoring_mode' => true,
                'read_only' => true,
                'student' => $assignmentUser->user->only(['id', 'name', 'email'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unauthorized to monitor this sistem',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function monitorFakturs(Request $request, AssignmentUser $assignmentUser, Sistem $sistem): JsonResponse
    {
        $user = auth()->user();

        try {
            // Verify monitoring permissions
            $this->monitoringService->getSistemForMonitoring($sistem, $user);

            $fakturs = $sistem->fakturs()->with('detail_transaksis')->get();

            return response()->json([
                'data' => $fakturs,
                'count' => $fakturs->count(),
                'is_monitoring_mode' => true,
                'read_only' => true,
                'student' => $assignmentUser->user->only(['id', 'name', 'email'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unauthorized to monitor fakturs',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function monitorBupots(Request $request, AssignmentUser $assignmentUser, Sistem $sistem): JsonResponse
    {
        $user = auth()->user();

        try {
            // Verify monitoring permissions
            $this->monitoringService->getSistemForMonitoring($sistem, $user);

            $bupots = $sistem->bupots()->with('bupot_dokumens')->get();

            return response()->json([
                'data' => $bupots,
                'count' => $bupots->count(),
                'is_monitoring_mode' => true,
                'read_only' => true,
                'student' => $assignmentUser->user->only(['id', 'name', 'email'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unauthorized to monitor bupots',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function monitorSpts(Request $request, AssignmentUser $assignmentUser, Sistem $sistem): JsonResponse
    {
        $user = auth()->user();

        try {
            // Verify monitoring permissions
            $this->monitoringService->getSistemForMonitoring($sistem, $user);

            $spts = $sistem->spts()->with(['spt_ppn', 'spt_pph'])->get();

            return response()->json([
                'data' => $spts,
                'count' => $spts->count(),
                'is_monitoring_mode' => true,
                'read_only' => true,
                'student' => $assignmentUser->user->only(['id', 'name', 'email'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unauthorized to monitor SPTs',
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function monitorPembayarans(Request $request, AssignmentUser $assignmentUser, Sistem $sistem): JsonResponse
    {
        $user = auth()->user();

        try {
            // Verify monitoring permissions
            $this->monitoringService->getSistemForMonitoring($sistem, $user);

            $pembayarans = $sistem->pembayarans()->get();

            return response()->json([
                'data' => $pembayarans,
                'count' => $pembayarans->count(),
                'is_monitoring_mode' => true,
                'read_only' => true,
                'student' => $assignmentUser->user->only(['id', 'name', 'email'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unauthorized to monitor pembayarans',
                'message' => $e->getMessage()
            ], 403);
        }
    }
}
