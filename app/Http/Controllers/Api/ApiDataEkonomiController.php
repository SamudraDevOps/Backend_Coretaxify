<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DataEkonomi\StoreDataEkonomiRequest;
use App\Http\Requests\DataEkonomi\UpdateDataEkonomiRequest;
use App\Http\Resources\DataEkonomiResource;
use App\Models\DataEkonomi;
use App\Support\Interfaces\Services\DataEkonomiServiceInterface;
use Illuminate\Http\Request;

class ApiDataEkonomiController extends ApiController {
    public function __construct(
        protected DataEkonomiServiceInterface $dataEkonomiService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return DataEkonomiResource::collection($this->dataEkonomiService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataEkonomiRequest $request) {
        return $this->dataEkonomiService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(DataEkonomi $dataEkonomi) {
        return new DataEkonomiResource($dataEkonomi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataEkonomiRequest $request, DataEkonomi $dataEkonomi) {
        return $this->dataEkonomiService->update($dataEkonomi, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DataEkonomi $dataEkonomi) {
        return $this->dataEkonomiService->delete($dataEkonomi);
    }
}