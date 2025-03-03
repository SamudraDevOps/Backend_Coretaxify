<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\WakilSayaInformasiUmum\StoreWakilSayaInformasiUmumRequest;
use App\Http\Requests\WakilSayaInformasiUmum\UpdateWakilSayaInformasiUmumRequest;
use App\Http\Resources\WakilSayaInformasiUmumResource;
use App\Models\WakilSayaInformasiUmum;
use App\Support\Interfaces\Services\WakilSayaInformasiUmumServiceInterface;
use Illuminate\Http\Request;

class ApiWakilSayaInformasiUmumController extends ApiController {
    public function __construct(
        protected WakilSayaInformasiUmumServiceInterface $wakilSayaInformasiUmumService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return WakilSayaInformasiUmumResource::collection($this->wakilSayaInformasiUmumService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWakilSayaInformasiUmumRequest $request) {
        return $this->wakilSayaInformasiUmumService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(WakilSayaInformasiUmum $wakilSayaInformasiUmum) {
        return new WakilSayaInformasiUmumResource($wakilSayaInformasiUmum);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWakilSayaInformasiUmumRequest $request, WakilSayaInformasiUmum $wakilSayaInformasiUmum) {
        return $this->wakilSayaInformasiUmumService->update($wakilSayaInformasiUmum, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, WakilSayaInformasiUmum $wakilSayaInformasiUmum) {
        return $this->wakilSayaInformasiUmumService->delete($wakilSayaInformasiUmum);
    }
}