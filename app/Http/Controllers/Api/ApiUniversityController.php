<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\University\StoreUniversityRequest;
use App\Http\Requests\University\UpdateUniversityRequest;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use App\Support\Interfaces\Services\UniversityServiceInterface;
use Illuminate\Http\Request;

class ApiUniversityController extends ApiController {
    public function __construct(
        protected UniversityServiceInterface $universityService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return UniversityResource::collection($this->universityService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUniversityRequest $request) {
        return $this->universityService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university) {
        return new UniversityResource($university->load(['roles' => ['division', 'permissions']]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversityRequest $request, University $university) {
        return $this->universityService->update($university, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, University $university) {
        return $this->universityService->delete($university);
    }
}