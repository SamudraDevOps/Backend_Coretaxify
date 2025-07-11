<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use Illuminate\Http\JsonResponse;
use App\Models\TempatKegiatanUsaha;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TempatKegiatanUsahaResource;
use App\Support\Interfaces\Services\TempatKegiatanUsahaServiceInterface;
use App\Http\Requests\TempatKegiatanUsaha\StoreTempatKegiatanUsahaRequest;
use App\Http\Requests\TempatKegiatanUsaha\UpdateTempatKegiatanUsahaRequest;

class ApiTempatKegiatanUsahaController extends ApiController {
    public function __construct(
        protected TempatKegiatanUsahaServiceInterface $tempatKegiatanUsahaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = $request->get('perPage', 20);

        $tempatKegiatanUsahas = $this->tempatKegiatanUsahaService->getAllForSistem(
            $assignment,
            $sistem,
            $request,
            $perPage
        );

        return TempatKegiatanUsahaResource::collection($tempatKegiatanUsahas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreTempatKegiatanUsahaRequest $request) {
        $this->tempatKegiatanUsahaService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $tempatKegiatanUsaha = $this->tempatKegiatanUsahaService->create($request->validated(), $sistem);

        return new TempatKegiatanUsahaResource($tempatKegiatanUsaha);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, TempatKegiatanUsaha $tempatKegiatanUsaha, Request $request) {
        $tempatKegiatanUsaha = $this->tempatKegiatanUsahaService->getTempatKegiatanUsahaDetail(
            $assignment,
            $sistem,
            $tempatKegiatanUsaha,
            $request
        );

        return new TempatKegiatanUsahaResource($tempatKegiatanUsaha);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Assignment $assignment,
        Sistem $sistem,
        UpdateTempatKegiatanUsahaRequest $request,
        TempatKegiatanUsaha $tempatKegiatanUsaha
    ): TempatKegiatanUsahaResource {
        $tempatKegiatanUsaha = $this->tempatKegiatanUsahaService->updateTempatKegiatanUsaha(
            $assignment,
            $sistem,
            $tempatKegiatanUsaha,
            $request->validated(),
            $request
        );

        return new TempatKegiatanUsahaResource($tempatKegiatanUsaha);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha,
        Request $request
    ): JsonResponse {
        $result = $this->tempatKegiatanUsahaService->deleteTempatKegiatanUsaha(
            $assignment,
            $sistem,
            $tempatKegiatanUsaha,
            $request
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Tempat kegiatan usaha deleted successfully' : 'Failed to delete tempat kegiatan usaha'
        ]);
    }

    //  /**
    //  * Get tempat kegiatan usaha by NITKU.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByNitku(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->tempatKegiatanUsahaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $nitku = $request->get('nitku');
    //     $tempatKegiatanUsahas = $this->tempatKegiatanUsahaService->getByNitku($nitku, $sistem->id);

    //     return TempatKegiatanUsahaResource::collection($tempatKegiatanUsahas);
    // }

    // /**
    //  * Get tempat kegiatan usaha by jenis TKU.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByJenisTku(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->tempatKegiatanUsahaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $jenisTku = $request->get('jenis_tku');
    //     $tempatKegiatanUsahas = $this->tempatKegiatanUsahaService->getByJenisTku($jenisTku, $sistem->id);

    //     return TempatKegiatanUsahaResource::collection($tempatKegiatanUsahas);
    // }

    // /**
    //  * Get tempat kegiatan usaha by nama TKU.
    //  *
    //  * @param Assignment $assignment
    //  * @param Sistem $sistem
    //  * @param Request $request
    //  * @return AnonymousResourceCollection
    //  */
    // public function getByNamaTku(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    // {
    //     // Authorize access to the sistem first
    //     $this->tempatKegiatanUsahaService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $namaTku = $request->get('nama_tku');
    //     $tempatKegiatanUsahas = $this->tempatKegiatanUsahaService->getByNamaTku($namaTku, $sistem->id);

    //     return TempatKegiatanUsahaResource::collection($tempatKegiatanUsahas);
    // }
}
