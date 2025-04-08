<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DetailTransaksi\StoreDetailTransaksiRequest;
use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Resources\FakturResource;
use App\Http\Requests\Faktur\StoreFakturRequest;
use App\Http\Requests\Faktur\UpdateFakturRequest;
use App\Support\Interfaces\Services\FakturServiceInterface;

class ApiFakturController extends ApiController {
    public function __construct(
        protected FakturServiceInterface $fakturService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return FakturResource::collection($this->fakturService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreFakturRequest $request) {
        $this->fakturService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $faktur = $this->fakturService->create($request->validated(), $sistem);

        return new FakturResource($faktur);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faktur $faktur) {
        $faktur->load('detail_transaksis');
        return new FakturResource($faktur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFakturRequest $request, Faktur $faktur) {
        $updatedFaktur = $this->fakturService->update($faktur, $request->validated());
        $updatedFaktur->load('detail_transaksis');
        return new FakturResource($updatedFaktur);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Faktur $faktur) {
        return $this->fakturService->delete($faktur);
    }

    public function addDetailTransaksi(Faktur $faktur, StoreDetailTransaksiRequest $request)
    {

        $detailTransaksi = $this->fakturService->addDetailTransaksi($faktur, $request->validated());

        return response()->json([
            'message' => 'Detail transaksi added successfully',
            'data' => $detailTransaksi
        ], 201);
    }
}
