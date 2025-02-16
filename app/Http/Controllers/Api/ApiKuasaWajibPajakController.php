<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\KuasaWajibPajak\StoreKuasaWajibPajakRequest;
use App\Http\Requests\KuasaWajibPajak\UpdateKuasaWajibPajakRequest;
use App\Http\Resources\KuasaWajibPajakResource;
use App\Models\KuasaWajibPajak;
use App\Support\Interfaces\Services\KuasaWajibPajakServiceInterface;
use Illuminate\Http\Request;

class ApiKuasaWajibPajakController extends ApiController {
    public function __construct(
        protected KuasaWajibPajakServiceInterface $kuasaWajibPajakService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return KuasaWajibPajakResource::collection($this->kuasaWajibPajakService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKuasaWajibPajakRequest $request) {
        return $this->kuasaWajibPajakService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(KuasaWajibPajak $kuasaWajibPajak) {
        return new KuasaWajibPajakResource($kuasaWajibPajak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKuasaWajibPajakRequest $request, KuasaWajibPajak $kuasaWajibPajak) {
        return $this->kuasaWajibPajakService->update($kuasaWajibPajak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, KuasaWajibPajak $kuasaWajibPajak) {
        return $this->kuasaWajibPajakService->delete($kuasaWajibPajak);
    }
}