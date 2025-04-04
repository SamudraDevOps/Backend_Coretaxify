<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Faktur\StoreFakturRequest;
use App\Http\Requests\Faktur\UpdateFakturRequest;
use App\Http\Resources\FakturResource;
use App\Models\Faktur;
use App\Support\Interfaces\Services\FakturServiceInterface;
use Illuminate\Http\Request;

class ApiFakturController extends ApiController {
    public function __construct(
        protected FakturServiceInterface $fakturService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return FakturResource::collection($this->fakturService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFakturRequest $request) {
        return $this->fakturService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Faktur $faktur) {
        return new FakturResource($faktur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFakturRequest $request, Faktur $faktur) {
        return $this->fakturService->update($faktur, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Faktur $faktur) {
        return $this->fakturService->delete($faktur);
    }
}