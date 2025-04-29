<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SptPpn\StoreSptPpnRequest;
use App\Http\Requests\SptPpn\UpdateSptPpnRequest;
use App\Http\Resources\SptPpnResource;
use App\Models\SptPpn;
use App\Support\Interfaces\Services\SptPpnServiceInterface;
use Illuminate\Http\Request;

class ApiSptPpnController extends ApiController {
    public function __construct(
        protected SptPpnServiceInterface $sptPpnService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return SptPpnResource::collection($this->sptPpnService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptPpnRequest $request) {
        return $this->sptPpnService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(SptPpn $sptPpn) {
        return new SptPpnResource($sptPpn);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptPpnRequest $request, SptPpn $sptPpn) {
        return $this->sptPpnService->update($sptPpn, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SptPpn $sptPpn) {
        return $this->sptPpnService->delete($sptPpn);
    }
}