<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Sistem\StoreSistemRequest;
use App\Http\Requests\Sistem\UpdateSistemRequest;
use App\Http\Resources\SistemResource;
use App\Models\Sistem;
use App\Support\Interfaces\Services\SistemServiceInterface;
use Illuminate\Http\Request;

class ApiSistemController extends ApiController {
    public function __construct(
        protected SistemServiceInterface $sistemService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return SistemResource::collection($this->sistemService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSistemRequest $request) {
        return $this->sistemService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Sistem $sistem) {
        return new SistemResource($sistem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSistemRequest $request, Sistem $sistem) {
        return $this->sistemService->update($sistem, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Sistem $sistem) {
        return $this->sistemService->delete($sistem);
    }
}