<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\TaskResource;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Support\Interfaces\Services\TaskServiceInterface;

class ApiTaskController extends ApiController {
    public function __construct(
        protected TaskServiceInterface $taskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);
        $user = auth()->user();

         // $tasks = $this->taskService->getTasksByUserId($user->id);
        $tasks = $this->taskService->getTasksByUserRole($user, $perPage);

        return TaskResource::collection($tasks);

        // return TaskResource::collection($this->taskService->getAllPaginated($request->query(), $perPage));
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
    public function show(Request $request, Task $task) {
        $intent = $request->get('intent');

        switch($intent) {
            case IntentEnum::API_USER_DOWNLOAD_SOAL->value:
                return $this->taskService->downloadFile($task);
        }
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task) {
        // dd($request->all());
        return $this->taskService->update($task, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task) {
        return $this->taskService->delete($task);
    }

    public function getContractTasks(Request $request) {
        $perPage = request()->get('perPage', 20);
        $user = auth()->user();

        return $user->contract->tasks;
    }

    public function downloadPublic(Request $request, Task $task) {
        // The 'signed' middleware has already verified the URL signature
        return $this->taskService->downloadFile($task);
    }
}
