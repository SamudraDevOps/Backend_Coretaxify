<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TempatKegiatanUsaha\StoreTempatKegiatanUsahaRequest;
use App\Http\Requests\TempatKegiatanUsaha\UpdateTempatKegiatanUsahaRequest;
use App\Http\Resources\TempatKegiatanUsahaResource;
use App\Models\TempatKegiatanUsaha;
use App\Support\Interfaces\Services\TempatKegiatanUsahaServiceInterface;
use Illuminate\Http\Request;

class ApiTempatKegiatanUsahaController extends ApiController {
    public function __construct(
        protected TempatKegiatanUsahaServiceInterface $tempatKegiatanUsahaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return TempatKegiatanUsahaResource::collection($this->tempatKegiatanUsahaService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTempatKegiatanUsahaRequest $request) {
        return $this->tempatKegiatanUsahaService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(TempatKegiatanUsaha $tempatKegiatanUsaha) {
        return new TempatKegiatanUsahaResource($tempatKegiatanUsaha);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTempatKegiatanUsahaRequest $request, TempatKegiatanUsaha $tempatKegiatanUsaha) {
        return $this->tempatKegiatanUsahaService->update($tempatKegiatanUsaha, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TempatKegiatanUsaha $tempatKegiatanUsaha) {
        return $this->tempatKegiatanUsahaService->delete($tempatKegiatanUsaha);
    }
}