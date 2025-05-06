<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BupotDokumen\StoreBupotDokumenRequest;
use App\Http\Requests\BupotDokumen\UpdateBupotDokumenRequest;
use App\Http\Resources\BupotDokumenResource;
use App\Models\BupotDokumen;
use App\Support\Interfaces\Services\BupotDokumenServiceInterface;
use Illuminate\Http\Request;

class ApiBupotDokumenController extends ApiController {
    public function __construct(
        protected BupotDokumenServiceInterface $bupotDokumenService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return BupotDokumenResource::collection($this->bupotDokumenService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotDokumenRequest $request) {
        return $this->bupotDokumenService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(BupotDokumen $bupotDokumen) {
        return new BupotDokumenResource($bupotDokumen);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotDokumenRequest $request, BupotDokumen $bupotDokumen) {
        return $this->bupotDokumenService->update($bupotDokumen, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BupotDokumen $bupotDokumen) {
        return $this->bupotDokumenService->delete($bupotDokumen);
    }
}