<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FakturScore\StoreFakturScoreRequest;
use App\Http\Requests\FakturScore\UpdateFakturScoreRequest;
use App\Http\Resources\FakturScoreResource;
use App\Models\FakturScore;
use App\Support\Interfaces\Services\FakturScoreServiceInterface;
use Illuminate\Http\Request;

class ApiFakturScoreController extends ApiController {
    public function __construct(
        protected FakturScoreServiceInterface $fakturScoreService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return FakturScoreResource::collection($this->fakturScoreService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFakturScoreRequest $request) {
        return $this->fakturScoreService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $assignment, $sistem, FakturScore $faktur_score) {
        return new FakturScoreResource($faktur_score);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFakturScoreRequest $request, $assignment, $sistem, FakturScore $faktur_score) {
        return $this->fakturScoreService->update($faktur_score, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $assignment, $sistem, FakturScore $faktur_score) {
        return $this->fakturScoreService->delete($faktur_score);
    }
}
