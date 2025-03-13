<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AssignmentUser\StoreAssignmentUserRequest;
use App\Http\Requests\AssignmentUser\UpdateAssignmentUserRequest;
use App\Http\Resources\AssignmentUserResource;
use App\Http\Resources\PicResource;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use App\Support\Interfaces\Services\AssignmentUserServiceInterface;
use Illuminate\Http\Request;

class ApiAssignmentUserController extends ApiController {
    public function __construct(
        protected AssignmentUserServiceInterface $assignmentUserService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);
        $user = auth()->user();
        $assignmentUser = $this->assignmentUserService->getAssignmentUserByUserId($user->id, $perPage);

        return AssignmentUserResource::collection($assignmentUser);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentUserRequest $request) {
        return $this->assignmentUserService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignmentUser $assignmentUser) {
        $intent = request()->get('intent');

        switch ($intent) {
            case IntentEnum::API_GET_ASSIGNMENT_USER_PIC->value:
                return PicResource::collection($this->assignmentUserService->getPic($assignmentUser));
        }

        return new AssignmentUserResource($assignmentUser);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentUserRequest $request, AssignmentUser $AssignmentUser) {
        return $this->assignmentUserService->update($AssignmentUser, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AssignmentUser $AssignmentUser) {
        return $this->assignmentUserService->delete($AssignmentUser);
    }
}
