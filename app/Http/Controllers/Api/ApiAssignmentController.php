<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\UserResource;
use App\Http\Resources\AssignmentResource;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Support\Interfaces\Services\AssignmentServiceInterface;

class ApiAssignmentController extends ApiController {
    public function __construct(
        protected AssignmentServiceInterface $assignmentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);
        $intent = request()->get('intent');
        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_GET_ASSIGNMENT_ALL->value:
                return AssignmentResource::collection($this->assignmentService->getAllPaginated($request->query(), $perPage)->load(['group']));
        }

        $assignments = $this->assignmentService->getAssignmentsByUserId($user->id, $perPage);

        // $assignments->load(['user', 'group']);

        // return $assignments;

        return AssignmentResource::collection($assignments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request) {
        $intent = $request->get('intent');
        // dd($request->all());
        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_ASSIGNMENT->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('instruktur') || $user->hasRole('admin')) {
                    return $this->assignmentService->create($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to create an assignment',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_ASSIGNMENT->value:
                if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
                    return $this->assignmentService->joinAssignment($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to join an assignment',
                    ], 403);
                }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request ,Assignment $assignment) {
        $intent = $request->get('intent');

        switch($intent) {
            case IntentEnum::API_USER_DOWNLOAD_FILE->value:
                return $this->assignmentService->downloadFile($assignment);
        }
        return new AssignmentResource($assignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment) {
        return $this->assignmentService->update($assignment, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Assignment $assignment) {
        return $this->assignmentService->delete($assignment);
    }
    public function getMembers(Request $request, Assignment $assignment) {
        $perPage = $request->get('perPage', 5);
        return UserResource::collection($assignment->users()->paginate($perPage));
    }

    public function removeMember(Assignment $assignment, User $user) {
        $assignment->users()->detach($user->id);
        return response()->json(['message' => 'Member removed successfully']);
    }

    public function getMemberDetail(Assignment $assignment, User $user) {
        return $assignment->users()->findOrFail($user->id);
    }
}
