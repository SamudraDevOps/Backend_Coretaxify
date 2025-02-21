<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DetailKontak\StoreDetailKontakRequest;
use App\Http\Requests\DetailKontak\UpdateDetailKontakRequest;
use App\Http\Resources\DetailKontakResource;
use App\Models\DetailKontak;
use App\Support\Interfaces\Services\DetailKontakServiceInterface;
use Illuminate\Http\Request;

class ApiDetailKontakController extends ApiController {
    public function __construct(
        protected DetailKontakServiceInterface $detailKontakService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return DetailKontakResource::collection($this->detailKontakService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailKontakRequest $request) {
        return $this->detailKontakService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailKontak $detailKontak) {
        return new DetailKontakResource($detailKontak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailKontakRequest $request, DetailKontak $detailKontak) {
        return $this->detailKontakService->update($detailKontak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DetailKontak $detailKontak) {
        return $this->detailKontakService->delete($detailKontak);
    }
}