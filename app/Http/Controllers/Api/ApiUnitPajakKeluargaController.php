<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\UnitPajakKeluarga;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UnitPajakKeluargaResource;
use App\Http\Requests\UnitPajakKeluarga\StoreUnitPajakKeluargaRequest;
use App\Support\Interfaces\Services\UnitPajakKeluargaServiceInterface;
use App\Http\Requests\UnitPajakKeluarga\UpdateUnitPajakKeluargaRequest;

class ApiUnitPajakKeluargaController extends ApiController {
    public function __construct(
        protected UnitPajakKeluargaServiceInterface $unitPajakKeluargaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = $request->get('perPage', 20);

        $unitPajakKeluargas = $this->unitPajakKeluargaService->getAllForSistem(
            $assignment,
            $sistem,
            $request,
            $perPage
        );

        return UnitPajakKeluargaResource::collection($unitPajakKeluargas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreUnitPajakKeluargaRequest $request) {
        $this->unitPajakKeluargaService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $unitPajakKeluarga = $this->unitPajakKeluargaService->create($request->validated(), $sistem);

        return new UnitPajakKeluargaResource($unitPajakKeluarga);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, UnitPajakKeluarga $unitPajakKeluarga, Request $request) {
        $unitPajakKeluarga = $this->unitPajakKeluargaService->getUnitPajakKeluargaDetail(
            $assignment,
            $sistem,
            $unitPajakKeluarga,
            $request
        );

        return new UnitPajakKeluargaResource($unitPajakKeluarga);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Assignment $assignment,
        Sistem $sistem,
        UpdateUnitPajakKeluargaRequest $request,
        UnitPajakKeluarga $unitPajakKeluarga
    ): UnitPajakKeluargaResource {
        $unitPajakKeluarga = $this->unitPajakKeluargaService->updateUnitPajakKeluarga(
            $assignment,
            $sistem,
            $unitPajakKeluarga,
            $request->validated(),
            $request
        );

        return new UnitPajakKeluargaResource($unitPajakKeluarga);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga,
        Request $request
    ): JsonResponse {
        $result = $this->unitPajakKeluargaService->deleteUnitPajakKeluarga(
            $assignment,
            $sistem,
            $unitPajakKeluarga,
            $request
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Unit pajak keluarga deleted successfully' : 'Failed to delete unit pajak keluarga'
        ]);
    }

    // /**
    //  * Get unit pajak keluarga by NIK.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByNik(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->unitPajakKeluargaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $nik = $request->get('nik');
    //     $unitPajakKeluargas = $this->unitPajakKeluargaService->getByNik($nik, $sistem->id);

    //     return UnitPajakKeluargaResource::collection($unitPajakKeluargas);
    // }

    // /**
    //  * Get unit pajak keluarga by nama anggota keluarga.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByNama(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->unitPajakKeluargaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $nama = $request->get('nama');
    //     $unitPajakKeluargas = $this->unitPajakKeluargaService->getByNama($nama, $sistem->id);

    //     return UnitPajakKeluargaResource::collection($unitPajakKeluargas);
    // }

    // /**
    //  * Get unit pajak keluarga by status hubungan keluarga.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByStatusHubungan(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->unitPajakKeluargaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $statusHubungan = $request->get('status_hubungan');
    //     $unitPajakKeluargas = $this->unitPajakKeluargaService->getByStatusHubungan($statusHubungan, $sistem->id);

    //     return UnitPajakKeluargaResource::collection($unitPajakKeluargas);
    // }

    // /**
    //  * Get unit pajak keluarga by nomor kartu keluarga.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByNomorKK(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->unitPajakKeluargaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $nomorKK = $request->get('nomor_kk');
    //     $unitPajakKeluargas = $this->unitPajakKeluargaService->getByNomorKK($nomorKK, $sistem->id);

    //     return UnitPajakKeluargaResource::collection($unitPajakKeluargas);
    // }
}
