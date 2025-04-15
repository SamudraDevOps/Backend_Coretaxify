<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\SistemTambahan;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\SistemTambahanResource;
use App\Http\Requests\SistemTambahan\StoreSistemTambahanRequest;
use App\Http\Requests\SistemTambahan\UpdateSistemTambahanRequest;
use App\Support\Interfaces\Services\SistemTambahanServiceInterface;

class ApiSistemTambahanController extends ApiController {
    public function __construct(
        protected SistemTambahanServiceInterface $sistemTambahanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment,Sistem $sistem ,Request $request) {
        $perPage = request()->get('perPage', 5);

        return SistemTambahanResource::collection($this->sistemTambahanService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment,Sistem $sistem ,StoreSistemTambahanRequest $request) {
        return $this->sistemTambahanService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment,Sistem $sistem ,SistemTambahan $sistemTambahan) {
        return new SistemTambahanResource($sistemTambahan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSistemTambahanRequest $request, SistemTambahan $sistemTambahan) {
        return $this->sistemTambahanService->update($sistemTambahan, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment,Sistem $sistem , Request $request, SistemTambahan $sistemTambahan) {
        return $this->sistemTambahanService->delete($sistemTambahan);
    }
}
