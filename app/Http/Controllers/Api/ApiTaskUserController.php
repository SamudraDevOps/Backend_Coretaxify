<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskUser\StoreTaskUserRequest;
use App\Http\Requests\TaskUser\UpdateTaskUserRequest;
use App\Http\Resources\TaskUserResource;
use App\Models\TaskUser;
use App\Support\Interfaces\Services\TaskUserServiceInterface;
use Illuminate\Http\Request;

class ApiTaskUserController extends ApiController {
    public function __construct(
        protected TaskUserServiceInterface $taskUserService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return TaskUserResource::collection($this->taskUserService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskUserRequest $request) {
        return $this->taskUserService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskUser $taskUser) {
        return new TaskUserResource($taskUser->load(['roles' => ['division', 'permissions']]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskUserRequest $request, TaskUser $taskUser) {
        return $this->taskUserService->update($taskUser, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TaskUser $taskUser) {
        return $this->taskUserService->delete($taskUser);
    }
}