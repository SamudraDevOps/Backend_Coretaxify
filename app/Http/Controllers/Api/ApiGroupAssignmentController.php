<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GroupAssignment\StoreGroupAssignmentRequest;
use App\Http\Requests\GroupAssignment\UpdateGroupAssignmentRequest;
use App\Http\Resources\GroupAssignmentResource;
use App\Models\GroupAssignment;
use App\Support\Interfaces\Services\GroupAssignmentServiceInterface;
use Illuminate\Http\Request;

class ApiGroupAssignmentController extends ApiController {
    public function __construct(
        protected GroupAssignmentServiceInterface $groupAssignmentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return GroupAssignmentResource::collection($this->groupAssignmentService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupAssignmentRequest $request) {
        return $this->groupAssignmentService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupAssignment $groupAssignment) {
        return new GroupAssignmentResource($groupAssignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupAssignmentRequest $request, GroupAssignment $groupAssignment) {
        return $this->groupAssignmentService->update($groupAssignment, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, GroupAssignment $groupAssignment) {
        return $this->groupAssignmentService->delete($groupAssignment);
    }
}