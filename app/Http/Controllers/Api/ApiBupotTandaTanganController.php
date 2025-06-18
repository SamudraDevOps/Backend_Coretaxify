<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BupotTandaTangan\StoreBupotTandaTanganRequest;
use App\Http\Requests\BupotTandaTangan\UpdateBupotTandaTanganRequest;
use App\Http\Resources\BupotTandaTanganResource;
use App\Models\BupotTandaTangan;
use App\Support\Interfaces\Services\BupotTandaTanganServiceInterface;
use Illuminate\Http\Request;

class ApiBupotTandaTanganController extends ApiController {
    public function __construct(
        protected BupotTandaTanganServiceInterface $bupotTandaTanganService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return BupotTandaTanganResource::collection($this->bupotTandaTanganService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotTandaTanganRequest $request) {
        return $this->bupotTandaTanganService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(BupotTandaTangan $bupotTandaTangan) {
        return new BupotTandaTanganResource($bupotTandaTangan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotTandaTanganRequest $request, BupotTandaTangan $bupotTandaTangan) {
        return $this->bupotTandaTanganService->update($bupotTandaTangan, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BupotTandaTangan $bupotTandaTangan) {
        return $this->bupotTandaTanganService->delete($bupotTandaTangan);
    }
}
