<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\KapKjs\StoreKapKjsRequest;
use App\Http\Requests\KapKjs\UpdateKapKjsRequest;
use App\Http\Resources\KapKjsResource;
use App\Models\KapKjs;
use App\Support\Interfaces\Services\KapKjsServiceInterface;
use Illuminate\Http\Request;

class ApiKapKjsController extends ApiController {
    public function __construct(
        protected KapKjsServiceInterface $kapKjsService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // $perPage = request()->get('perPage', 20);

        // return KapKjsResource::collection($this->kapKjsService->getAllPaginated($request->query(), $perPage));

        return KapKjsResource::collection($this->kapKjsService->getAll($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKapKjsRequest $request) {
        return $this->kapKjsService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(KapKjs $kapKjs) {
        return new KapKjsResource($kapKjs);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKapKjsRequest $request, KapKjs $kapKjs) {
        return $this->kapKjsService->update($kapKjs, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, KapKjs $kapKjs) {
        return $this->kapKjsService->delete($kapKjs);
    }
}
