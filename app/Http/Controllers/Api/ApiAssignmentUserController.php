<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AssignmentUser\StoreAssignmentUserRequest;
use App\Http\Requests\AssignmentUser\UpdateAssignmentUserRequest;
use App\Http\Resources\AssignmentUserResource;
use App\Models\AssignmentUser;
use App\Support\Interfaces\Services\AssignmentUserServiceInterface;
use Illuminate\Http\Request;

class ApiAssignmentUserController extends ApiController {
    public function __construct(
        protected AssignmentUserServiceInterface $AssignmentUserService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);
        $user = auth()->user();
        $assignmentUser = $this->AssignmentUserService->getAssignmentUserByUserId($user->id, $perPage);

        return AssignmentUserResource::collection($assignmentUser);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentUserRequest $request) {
        return $this->AssignmentUserService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignmentUser $AssignmentUser) {
        return new AssignmentUserResource($AssignmentUser);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentUserRequest $request, AssignmentUser $AssignmentUser) {
        return $this->AssignmentUserService->update($AssignmentUser, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AssignmentUser $AssignmentUser) {
        return $this->AssignmentUserService->delete($AssignmentUser);
    }
}