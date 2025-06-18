<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\KodeTransaksi\StoreKodeTransaksiRequest;
use App\Http\Requests\KodeTransaksi\UpdateKodeTransaksiRequest;
use App\Http\Resources\KodeTransaksiResource;
use App\Models\KodeTransaksi;
use App\Support\Interfaces\Services\KodeTransaksiServiceInterface;
use Illuminate\Http\Request;

class ApiKodeTransaksiController extends ApiController {
    public function __construct(
        protected KodeTransaksiServiceInterface $kodeTransaksiService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // $perPage = request()->get('perPage', 20);

        // return KodeTransaksiResource::collection($this->kodeTransaksiService->getAllPaginated($request->query(), $perPage));
        return KodeTransaksiResource::collection($this->kodeTransaksiService->getAll($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKodeTransaksiRequest $request) {
        return $this->kodeTransaksiService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeTransaksi $kodeTransaksi) {
        return new KodeTransaksiResource($kodeTransaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKodeTransaksiRequest $request, KodeTransaksi $kodeTransaksi) {
        return $this->kodeTransaksiService->update($kodeTransaksi, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, KodeTransaksi $kodeTransaksi) {
        return $this->kodeTransaksiService->delete($kodeTransaksi);
    }
}
