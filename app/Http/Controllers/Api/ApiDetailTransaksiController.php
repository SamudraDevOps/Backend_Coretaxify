<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DetailTransaksi\StoreDetailTransaksiRequest;
use App\Http\Requests\DetailTransaksi\UpdateDetailTransaksiRequest;
use App\Http\Resources\DetailTransaksiResource;
use App\Models\DetailTransaksi;
use App\Support\Interfaces\Services\DetailTransaksiServiceInterface;
use Illuminate\Http\Request;

class ApiDetailTransaksiController extends ApiController {
    public function __construct(
        protected DetailTransaksiServiceInterface $detailTransaksiService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return DetailTransaksiResource::collection($this->detailTransaksiService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailTransaksiRequest $request) {
        return $this->detailTransaksiService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailTransaksi $detailTransaksi) {
        return new DetailTransaksiResource($detailTransaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailTransaksiRequest $request, DetailTransaksi $detailTransaksi) {
        return $this->detailTransaksiService->update($detailTransaksi, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DetailTransaksi $detailTransaksi) {
        return $this->detailTransaksiService->delete($detailTransaksi);
    }
}