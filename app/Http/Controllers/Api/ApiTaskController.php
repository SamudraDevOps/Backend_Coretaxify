<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Support\Interfaces\Services\TaskServiceInterface;
use Illuminate\Http\Request;

class ApiTaskController extends ApiController {
    public function __construct(
        protected TaskServiceInterface $taskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return TaskResource::collection($this->taskService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request) {
        return $this->taskService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task) {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task) {
        return $this->taskService->update($task, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task) {
        return $this->taskService->delete($task);
    }
}
