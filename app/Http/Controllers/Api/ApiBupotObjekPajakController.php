<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BupotObjekPajak\StoreBupotObjekPajakRequest;
use App\Http\Requests\BupotObjekPajak\UpdateBupotObjekPajakRequest;
use App\Http\Resources\BupotObjekPajakResource;
use App\Models\BupotObjekPajak;
use App\Support\Interfaces\Services\BupotObjekPajakServiceInterface;
use Illuminate\Http\Request;

class ApiBupotObjekPajakController extends ApiController {
    public function __construct(
        protected BupotObjekPajakServiceInterface $bupotObjekPajakService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotObjekPajakRequest $request) {
        return $this->bupotObjekPajakService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(BupotObjekPajak $bupotObjekPajak) {
        return new BupotObjekPajakResource($bupotObjekPajak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotObjekPajakRequest $request, BupotObjekPajak $bupotObjekPajak) {
        return $this->bupotObjekPajakService->update($bupotObjekPajak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BupotObjekPajak $bupotObjekPajak) {
        return $this->bupotObjekPajakService->delete($bupotObjekPajak);
    }
}