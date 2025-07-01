<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SptUnifikasi\StoreSptUnifikasiRequest;
use App\Http\Requests\SptUnifikasi\UpdateSptUnifikasiRequest;
use App\Http\Resources\SptUnifikasiResource;
use App\Models\SptUnifikasi;
use App\Support\Interfaces\Services\SptUnifikasiServiceInterface;
use Illuminate\Http\Request;

class ApiSptUnifikasiController extends ApiController {
    public function __construct(
        protected SptUnifikasiServiceInterface $sptUnifikasiService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return SptUnifikasiResource::collection($this->sptUnifikasiService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptUnifikasiRequest $request) {
        return $this->sptUnifikasiService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(SptUnifikasi $sptUnifikasi) {
        return new SptUnifikasiResource($sptUnifikasi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptUnifikasiRequest $request, SptUnifikasi $sptUnifikasi) {
        return $this->sptUnifikasiService->update($sptUnifikasi, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SptUnifikasi $sptUnifikasi) {
        return $this->sptUnifikasiService->delete($sptUnifikasi);
    }
}