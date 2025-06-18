<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Dummy\StoreDummyRequest;
use App\Http\Requests\Dummy\UpdateDummyRequest;
use App\Http\Resources\DummyResource;
use App\Models\Dummy;
use App\Support\Interfaces\Services\DummyServiceInterface;
use Illuminate\Http\Request;

class ApiDummyController extends ApiController {
    public function __construct(
        protected DummyServiceInterface $dummyService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return DummyResource::collection($this->dummyService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDummyRequest $request) {
        return $this->dummyService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Dummy $dummy) {
        return new DummyResource($dummy);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDummyRequest $request, Dummy $dummy) {
        return $this->dummyService->update($dummy, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Dummy $dummy) {
        return $this->dummyService->delete($dummy);
    }
}
