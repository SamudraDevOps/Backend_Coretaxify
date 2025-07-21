<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SptScore\StoreSptScoreRequest;
use App\Http\Requests\SptScore\UpdateSptScoreRequest;
use App\Http\Resources\SptScoreResource;
use App\Models\SptScore;
use App\Support\Interfaces\Services\SptScoreServiceInterface;
use Illuminate\Http\Request;

class ApiSptScoreController extends ApiController {
    public function __construct(
        protected SptScoreServiceInterface $sptScoreService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return SptScoreResource::collection($this->sptScoreService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptScoreRequest $request) {
        return $this->sptScoreService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $assignment, $sistem, SptScore $spt_score) {
        return new SptScoreResource($spt_score);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptScoreRequest $request, $assignment, $sistem, SptScore $spt_score) {
        return $this->sptScoreService->update($spt_score, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $assignment, $sistem, SptScore $spt_score) {
        return $this->sptScoreService->delete($spt_score);
    }
}
