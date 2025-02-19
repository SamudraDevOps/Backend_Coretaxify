<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PortalSaya\StorePortalSayaRequest;
use App\Http\Requests\PortalSaya\UpdatePortalSayaRequest;
use App\Http\Resources\PortalSayaResource;
use App\Models\PortalSaya;
use App\Support\Interfaces\Services\PortalSayaServiceInterface;
use Illuminate\Http\Request;

class ApiPortalSayaController extends ApiController {
    public function __construct(
        protected PortalSayaServiceInterface $portalSayaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return PortalSayaResource::collection($this->portalSayaService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePortalSayaRequest $request) {
        return $this->portalSayaService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(PortalSaya $portalSaya) {
        return new PortalSayaResource($portalSaya);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePortalSayaRequest $request, PortalSaya $portalSaya) {
        return $this->portalSayaService->update($portalSaya, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PortalSaya $portalSaya) {
        return $this->portalSayaService->delete($portalSaya);
    }
}