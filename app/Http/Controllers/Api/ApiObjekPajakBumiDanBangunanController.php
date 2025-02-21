<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ObjekPajakBumiDanBangunan\StoreObjekPajakBumiDanBangunanRequest;
use App\Http\Requests\ObjekPajakBumiDanBangunan\UpdateObjekPajakBumiDanBangunanRequest;
use App\Http\Resources\ObjekPajakBumiDanBangunanResource;
use App\Models\ObjekPajakBumiDanBangunan;
use App\Support\Interfaces\Services\ObjekPajakBumiDanBangunanServiceInterface;
use Illuminate\Http\Request;

class ApiObjekPajakBumiDanBangunanController extends ApiController {
    public function __construct(
        protected ObjekPajakBumiDanBangunanServiceInterface $objekPajakBumiDanBangunanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return ObjekPajakBumiDanBangunanResource::collection($this->objekPajakBumiDanBangunanService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObjekPajakBumiDanBangunanRequest $request) {
        return $this->objekPajakBumiDanBangunanService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(ObjekPajakBumiDanBangunan $objekPajakBumiDanBangunan) {
        return new ObjekPajakBumiDanBangunanResource($objekPajakBumiDanBangunan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObjekPajakBumiDanBangunanRequest $request, ObjekPajakBumiDanBangunan $objekPajakBumiDanBangunan) {
        return $this->objekPajakBumiDanBangunanService->update($objekPajakBumiDanBangunan, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ObjekPajakBumiDanBangunan $objekPajakBumiDanBangunan) {
        return $this->objekPajakBumiDanBangunanService->delete($objekPajakBumiDanBangunan);
    }
}