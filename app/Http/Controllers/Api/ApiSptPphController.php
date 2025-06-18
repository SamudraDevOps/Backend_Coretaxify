<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SptPph\StoreSptPphRequest;
use App\Http\Requests\SptPph\UpdateSptPphRequest;
use App\Http\Resources\SptPphResource;
use App\Models\SptPph;
use App\Support\Interfaces\Services\SptPphServiceInterface;
use Illuminate\Http\Request;

class ApiSptPphController extends ApiController {
    public function __construct(
        protected SptPphServiceInterface $sptPphService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return SptPphResource::collection($this->sptPphService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptPphRequest $request) {
        return $this->sptPphService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(SptPph $sptPph) {
        return new SptPphResource($sptPph);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptPphRequest $request, SptPph $sptPph) {
        return $this->sptPphService->update($sptPph, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SptPph $sptPph) {
        return $this->sptPphService->delete($sptPph);
    }
}
