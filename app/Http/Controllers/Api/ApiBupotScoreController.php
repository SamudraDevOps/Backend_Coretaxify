<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BupotScore\StoreBupotScoreRequest;
use App\Http\Requests\BupotScore\UpdateBupotScoreRequest;
use App\Http\Resources\BupotScoreResource;
use App\Models\BupotScore;
use App\Support\Interfaces\Services\BupotScoreServiceInterface;
use Illuminate\Http\Request;

class ApiBupotScoreController extends ApiController {
    public function __construct(
        protected BupotScoreServiceInterface $bupotScoreService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return BupotScoreResource::collection($this->bupotScoreService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotScoreRequest $request) {
        return $this->bupotScoreService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $assignment, $sistem, BupotScore $bupot_score) {
        return new BupotScoreResource($bupot_score);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotScoreRequest $request,  $assignment, $sistem, BupotScore $bupot_score) {
        return $this->bupotScoreService->update($bupot_score, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $assignment, $sistem, BupotScore $bupot_score) {
        return $this->bupotScoreService->delete($bupot_score);
    }
}
