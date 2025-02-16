<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InformasiUmum\StoreInformasiUmumRequest;
use App\Http\Requests\InformasiUmum\UpdateInformasiUmumRequest;
use App\Http\Resources\InformasiUmumResource;
use App\Models\InformasiUmum;
use App\Support\Interfaces\Services\InformasiUmumServiceInterface;
use Illuminate\Http\Request;

class ApiInformasiUmumController extends ApiController {
    public function __construct(
        protected InformasiUmumServiceInterface $informasiUmumService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return InformasiUmumResource::collection($this->informasiUmumService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInformasiUmumRequest $request) {
        return $this->informasiUmumService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiUmum $informasiUmum) {
        return new InformasiUmumResource($informasiUmum);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInformasiUmumRequest $request, InformasiUmum $informasiUmum) {
        return $this->informasiUmumService->update($informasiUmum, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, InformasiUmum $informasiUmum) {
        return $this->informasiUmumService->delete($informasiUmum);
    }
}