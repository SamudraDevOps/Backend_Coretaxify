<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InformasiTambahan\StoreInformasiTambahanRequest;
use App\Http\Requests\InformasiTambahan\UpdateInformasiTambahanRequest;
use App\Http\Resources\InformasiTambahanResource;
use App\Models\InformasiTambahan;
use App\Support\Interfaces\Services\InformasiTambahanServiceInterface;
use Illuminate\Http\Request;

class ApiInformasiTambahanController extends ApiController {
    public function __construct(
        protected InformasiTambahanServiceInterface $informasiTambahanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // $perPage = request()->get('perPage', 5);

        // return InformasiTambahanResource::collection($this->informasiTambahanService->getAllPaginated($request->query(), $perPage));

        return InformasiTambahanResource::collection($this->informasiTambahanService->getAll($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInformasiTambahanRequest $request) {
        return $this->informasiTambahanService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(InformasiTambahan $informasiTambahan) {
        return new InformasiTambahanResource($informasiTambahan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInformasiTambahanRequest $request, InformasiTambahan $informasiTambahan) {
        return $this->informasiTambahanService->update($informasiTambahan, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, InformasiTambahan $informasiTambahan) {
        return $this->informasiTambahanService->delete($informasiTambahan);
    }
}