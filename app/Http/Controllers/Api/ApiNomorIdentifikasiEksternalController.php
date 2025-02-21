<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NomorIdentifikasiEksternal\StoreNomorIdentifikasiEksternalRequest;
use App\Http\Requests\NomorIdentifikasiEksternal\UpdateNomorIdentifikasiEksternalRequest;
use App\Http\Resources\NomorIdentifikasiEksternalResource;
use App\Models\NomorIdentifikasiEksternal;
use App\Support\Interfaces\Services\NomorIdentifikasiEksternalServiceInterface;
use Illuminate\Http\Request;

class ApiNomorIdentifikasiEksternalController extends ApiController {
    public function __construct(
        protected NomorIdentifikasiEksternalServiceInterface $nomorIdentifikasiEksternalService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

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
    public function update(UpdateNomorIdentifikasiEksternalRequest $request, NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        return $this->nomorIdentifikasiEksternalService->update($nomorIdentifikasiEksternal, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        return $this->nomorIdentifikasiEksternalService->delete($nomorIdentifikasiEksternal);
    }
}