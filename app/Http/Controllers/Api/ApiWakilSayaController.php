<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\WakilSaya\StoreWakilSayaRequest;
use App\Http\Requests\WakilSaya\UpdateWakilSayaRequest;
use App\Http\Resources\WakilSayaResource;
use App\Models\WakilSaya;
use App\Support\Interfaces\Services\WakilSayaServiceInterface;
use Illuminate\Http\Request;

class ApiWakilSayaController extends ApiController {
    public function __construct(
        protected WakilSayaServiceInterface $wakilSayaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return WakilSayaResource::collection($this->wakilSayaService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWakilSayaRequest $request) {
        return $this->wakilSayaService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(WakilSaya $wakilSaya) {
        return new WakilSayaResource($wakilSaya);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWakilSayaRequest $request, WakilSaya $wakilSaya) {
        return $this->wakilSayaService->update($wakilSaya, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, WakilSaya $wakilSaya) {
        return $this->wakilSayaService->delete($wakilSaya);
    }
}