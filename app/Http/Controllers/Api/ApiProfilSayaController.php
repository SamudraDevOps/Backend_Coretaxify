<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProfilSaya\StoreProfilSayaRequest;
use App\Http\Requests\ProfilSaya\UpdateProfilSayaRequest;
use App\Http\Resources\ProfilSayaResource;
use App\Models\ProfilSaya;
use App\Support\Interfaces\Services\ProfilSayaServiceInterface;
use Illuminate\Http\Request;

class ApiProfilSayaController extends ApiController {
    public function __construct(
        protected ProfilSayaServiceInterface $profilSayaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return ProfilSayaResource::collection($this->profilSayaService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfilSayaRequest $request) {
        return $this->profilSayaService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilSaya $profilSaya) {
        return new ProfilSayaResource($profilSaya);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilSayaRequest $request, ProfilSaya $profilSaya) {
        return $this->profilSayaService->update($profilSaya, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ProfilSaya $profilSaya) {
        return $this->profilSayaService->delete($profilSaya);
    }
}
