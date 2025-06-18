<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\NomorIdentifikasiEksternal;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\NomorIdentifikasiEksternalResource;
use App\Support\Interfaces\Services\NomorIdentifikasiEksternalServiceInterface;
use App\Http\Requests\NomorIdentifikasiEksternal\StoreNomorIdentifikasiEksternalRequest;
use App\Http\Requests\NomorIdentifikasiEksternal\UpdateNomorIdentifikasiEksternalRequest;

class ApiNomorIdentifikasiEksternalController extends ApiController {
    public function __construct(
        protected NomorIdentifikasiEksternalServiceInterface $nomorIdentifikasiEksternalService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return NomorIdentifikasiEksternalResource::collection($this->nomorIdentifikasiEksternalService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNomorIdentifikasiEksternalRequest $request) {
        return $this->nomorIdentifikasiEksternalService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        return new NomorIdentifikasiEksternalResource($nomorIdentifikasiEksternal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateNomorIdentifikasiEksternalRequest $request, NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        $sistem = Sistem::with('profil_saya.nomor_identifikasi_eksternal')->findOrFail($sistem->id);

        $sistem->profil_saya->nomor_identifikasi_eksternal->update($request->validated());

        return $nomorIdentifikasiEksternal;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        return $this->nomorIdentifikasiEksternalService->delete($nomorIdentifikasiEksternal);
    }
}
