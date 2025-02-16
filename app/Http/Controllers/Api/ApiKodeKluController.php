<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\KodeKlu\StoreKodeKluRequest;
use App\Http\Requests\KodeKlu\UpdateKodeKluRequest;
use App\Http\Resources\KodeKluResource;
use App\Models\KodeKlu;
use App\Support\Interfaces\Services\KodeKluServiceInterface;
use Illuminate\Http\Request;

class ApiKodeKluController extends ApiController {
    public function __construct(
        protected KodeKluServiceInterface $kodeKluService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return KodeKluResource::collection($this->kodeKluService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKodeKluRequest $request) {
        return $this->kodeKluService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeKlu $kodeKlu) {
        return new KodeKluResource($kodeKlu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKodeKluRequest $request, KodeKlu $kodeKlu) {
        return $this->kodeKluService->update($kodeKlu, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, KodeKlu $kodeKlu) {
        return $this->kodeKluService->delete($kodeKlu);
    }
}