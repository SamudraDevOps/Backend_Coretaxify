<?php

namespace App\Http\Controllers\Api;

use App\Models\Bupot;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Support\Enums\BupotTypeEnum;
use App\Http\Resources\BupotResource;
use App\Http\Requests\Bupot\HapusBupotRequest;
use App\Http\Requests\Bupot\StoreBupotRequest;
use App\Http\Requests\Bupot\TerbitBupotRequest;
use App\Http\Requests\Bupot\UpdateBupotRequest;
use App\Support\Interfaces\Services\BupotServiceInterface;

class ApiBupotController extends ApiController {
    public function __construct(
        protected BupotServiceInterface $bupotService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return BupotResource::collection($this->bupotService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotRequest $request) {
        return $this->bupotService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Bupot $bupot) {
        return new BupotResource($bupot);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotRequest $request, Bupot $bupot) {
        return $this->bupotService->update($bupot, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Bupot $bupot) {
        return $this->bupotService->delete($bupot);
    }

    public function penerbitan(TerbitBupotRequest $request) {
        \Illuminate\Support\Facades\Log::info('Request data: ' . json_encode($request->validated()));
        return $this->bupotService->penerbitan($request->validated());
    }

    public function penghapusan(HapusBupotRequest $request) {
        return $this->bupotService->penghapusan($request->validated());
    }
}
