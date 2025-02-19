<?php

namespace App\Http\Controllers\Api;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
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

        $user = auth()->user();

        if ($user->hasRole('dosen')) {
            return $this->assignmentService->getAssignmentsByUserId($user->id)->load('user');
        } else if ($user->hasRole('mahasiswa')) {
            return $this->assignmentService->getAssignmentsByUserId($user->id)->load('user');
        } else if ($user->hasRole('psc')) {
            return $this->assignmentService->getAssignmentsByUserId($user->id)->load('user');
        }

        return AssignmentResource::collection($this->assignmentService->getAllPaginated($request->query(), $perPage)->load(['group']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request) {
        $intent = $request->get('intent');

        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_ASSIGNMENT->value:
                if ($user->hasRole('dosen')) {
                    return $this->assignmentService->create($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to create an assignment',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_ASSIGNMENT->value:
                if ($user->hasRole('mahasiswa')) {
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
    public function show(Assignment $assignment) {
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
}
