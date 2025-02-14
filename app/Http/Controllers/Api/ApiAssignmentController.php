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
        protected AssignmentServiceInterface $AssignmentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return AssignmentResource::collection($this->AssignmentService->getAllPaginated($request->query(), $perPage)->load(['group', 'task']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request) {
        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_ASSIGNMENT->value:
                return $this->AssignmentService->create($request->validated());
            case IntentEnum::API_USER_ASSIGN_TASK->value:
                return $this->AssignmentService->assignTask($request->validated());    
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $Assignment) {
        return new AssignmentResource($Assignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $Assignment) {
        return $this->AssignmentService->update($Assignment, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Assignment $Assignment) {
        return $this->AssignmentService->delete($Assignment);
    }
}