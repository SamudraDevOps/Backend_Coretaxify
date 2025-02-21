<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ManajemenKasus\StoreManajemenKasusRequest;
use App\Http\Requests\ManajemenKasus\UpdateManajemenKasusRequest;
use App\Http\Resources\ManajemenKasusResource;
use App\Models\ManajemenKasus;
use App\Support\Interfaces\Services\ManajemenKasusServiceInterface;
use Illuminate\Http\Request;

class ApiManajemenKasusController extends ApiController {
    public function __construct(
        protected ManajemenKasusServiceInterface $manajemenKasusService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return ManajemenKasusResource::collection($this->manajemenKasusService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManajemenKasusRequest $request) {
        return $this->manajemenKasusService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(ManajemenKasus $manajemenKasus) {
        return new ManajemenKasusResource($manajemenKasus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManajemenKasusRequest $request, ManajemenKasus $manajemenKasus) {
        return $this->manajemenKasusService->update($manajemenKasus, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ManajemenKasus $manajemenKasus) {
        return $this->manajemenKasusService->delete($manajemenKasus);
    }
}