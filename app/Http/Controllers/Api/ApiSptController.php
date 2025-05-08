<?php

namespace App\Http\Controllers\Api;

use App\Models\Spt;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Resources\SptResource;
use App\Http\Requests\Spt\StoreSptRequest;
use App\Http\Requests\Spt\UpdateSptRequest;
use App\Support\Interfaces\Services\SptServiceInterface;

class ApiSptController extends ApiController {
    public function __construct(
        protected SptServiceInterface $sptService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->sptService->authorizeAccess($assignment, $sistem);

        $perPage = request()->get('perPage', 5);

        $spts = $this->sptService->getAllForSpt($sistem, $perPage);

        return SptResource::collection($spts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->sptService->authorizeAccess($assignment, $sistem);

        $data = $request->all();
        $data['masa_bulan'] = $request->masa_bulan;
        $data['masa_tahun'] = $request->masa_tahun;
        $data['sistem_id'] = $sistem->id;
        $data['pic_id'] = $request->pic_id;
        $data['jenis_pajak'] = $request->jenis_pajak;
        $data['model'] = $request->model;

        return $this->sptService->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, Spt $spt, Request $request) {
        $this->sptService->authorizeAccess($assignment, $sistem);

        $detail_spt = $this->sptService->showDetailSpt($spt);

        return new SptResource($detail_spt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptRequest $request, Spt $spt) {
        return $this->sptService->update($spt, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Spt $spt) {
        return $this->sptService->delete($spt);
    }

    public function checkPeriode(Assignment $assignment, Sistem $sistem, Request $request) {
        return $this->sptService->checkPeriode($assignment, $sistem, $request);
    }

    public function calculateSpt(Assignment $assignment, Sistem $sistem, Spt $spt, Request $request) {
        $this->sptService->authorizeAccess($assignment, $sistem);
        
        return $this->sptService->calculateSpt($spt, $request);
    }
}
