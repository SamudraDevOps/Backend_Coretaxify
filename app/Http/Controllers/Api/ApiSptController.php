<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Spt\StoreSptRequest;
use App\Http\Requests\Spt\UpdateSptRequest;
use App\Http\Resources\SptResource;
use App\Models\Spt;
use App\Support\Interfaces\Services\SptServiceInterface;
use Illuminate\Http\Request;

class ApiSptController extends ApiController {
    public function __construct(
        protected SptServiceInterface $sptService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return SptResource::collection($this->sptService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptRequest $request) {
        return $this->sptService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Spt $spt) {
        return new SptResource($spt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptRequest $request, Spt $spt) {
        return $this->sptService->update($spt, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Spt $spt) {
        return $this->sptService->delete($spt);
    }
}