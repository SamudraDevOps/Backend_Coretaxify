<?php

namespace App\Http\Controllers\Api;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DetailTransaksiResource;
use App\Http\Requests\DetailTransaksi\StoreDetailTransaksiRequest;
use App\Http\Requests\DetailTransaksi\UpdateDetailTransaksiRequest;
use App\Support\Interfaces\Services\DetailTransaksiServiceInterface;

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
    public function store(Assignment $assignment, Sistem $sistem, Faktur $faktur, StoreDetailTransaksiRequest $request) {
        $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);

        return $this->detailTransaksiService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, Faktur $faktur, DetailTransaksi $detailTransaksi) {
        $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $this->detailTransaksiService->authorizeDetailTraBelongsToFaktur($faktur, $detailTransaksi);

        return new DetailTransaksiResource($detailTransaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, Faktur $faktur, UpdateDetailTransaksiRequest $request, DetailTransaksi $detailTransaksi) {
        $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $this->detailTransaksiService->authorizeDetailTraBelongsToFaktur($faktur, $detailTransaksi);

        return $this->detailTransaksiService->update($detailTransaksi, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment, Sistem $sistem, Faktur $faktur, DetailTransaksi $detailTransaksi) {
        $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $this->detailTransaksiService->authorizeDetailTraBelongsToFaktur($faktur, $detailTransaksi);

        return $this->detailTransaksiService->delete($detailTransaksi);
    }
}
