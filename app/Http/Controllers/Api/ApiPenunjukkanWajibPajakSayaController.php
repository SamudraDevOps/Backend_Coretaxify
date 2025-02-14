<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PenunjukkanWajibPajakSaya\StorePenunjukkanWajibPajakSayaRequest;
use App\Http\Requests\PenunjukkanWajibPajakSaya\UpdatePenunjukkanWajibPajakSayaRequest;
use App\Http\Resources\PenunjukkanWajibPajakSayaResource;
use App\Models\PenunjukkanWajibPajakSaya;
use App\Support\Interfaces\Services\PenunjukkanWajibPajakSayaServiceInterface;
use Illuminate\Http\Request;

class ApiPenunjukkanWajibPajakSayaController extends ApiController {
    public function __construct(
        protected PenunjukkanWajibPajakSayaServiceInterface $penunjukkanWajibPajakSayaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return PenunjukkanWajibPajakSayaResource::collection($this->penunjukkanWajibPajakSayaService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenunjukkanWajibPajakSayaRequest $request) {
        return $this->penunjukkanWajibPajakSayaService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(PenunjukkanWajibPajakSaya $penunjukkanWajibPajakSaya) {
        return new PenunjukkanWajibPajakSayaResource($penunjukkanWajibPajakSaya);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenunjukkanWajibPajakSayaRequest $request, PenunjukkanWajibPajakSaya $penunjukkanWajibPajakSaya) {
        return $this->penunjukkanWajibPajakSayaService->update($penunjukkanWajibPajakSaya, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PenunjukkanWajibPajakSaya $penunjukkanWajibPajakSaya) {
        return $this->penunjukkanWajibPajakSayaService->delete($penunjukkanWajibPajakSaya);
    }
}