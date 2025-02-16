<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AlamatWajibPajak\StoreAlamatWajibPajakRequest;
use App\Http\Requests\AlamatWajibPajak\UpdateAlamatWajibPajakRequest;
use App\Http\Resources\AlamatWajibPajakResource;
use App\Models\AlamatWajibPajak;
use App\Support\Interfaces\Services\AlamatWajibPajakServiceInterface;
use Illuminate\Http\Request;

class ApiAlamatWajibPajakController extends ApiController {
    public function __construct(
        protected AlamatWajibPajakServiceInterface $alamatWajibPajakService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return AlamatWajibPajakResource::collection($this->alamatWajibPajakService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlamatWajibPajakRequest $request) {
        return $this->alamatWajibPajakService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AlamatWajibPajak $alamatWajibPajak) {
        return new AlamatWajibPajakResource($alamatWajibPajak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlamatWajibPajakRequest $request, AlamatWajibPajak $alamatWajibPajak) {
        return $this->alamatWajibPajakService->update($alamatWajibPajak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AlamatWajibPajak $alamatWajibPajak) {
        return $this->alamatWajibPajakService->delete($alamatWajibPajak);
    }
}