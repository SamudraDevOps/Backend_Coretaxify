<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Satuan\StoreSatuanRequest;
use App\Http\Requests\Satuan\UpdateSatuanRequest;
use App\Http\Resources\SatuanResource;
use App\Models\Satuan;
use App\Support\Interfaces\Services\SatuanServiceInterface;
use Illuminate\Http\Request;

class ApiSatuanController extends ApiController {
    public function __construct(
        protected SatuanServiceInterface $satuanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // $perPage = request()->get('perPage', 20);

        // return SatuanResource::collection($this->satuanService->getAllPaginated($request->query(), $perPage));

        return SatuanResource::collection($this->satuanService->getAll($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSatuanRequest $request) {
        return $this->satuanService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan) {
        return new SatuanResource($satuan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSatuanRequest $request, Satuan $satuan) {
        return $this->satuanService->update($satuan, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Satuan $satuan) {
        return $this->satuanService->delete($satuan);
    }
}
