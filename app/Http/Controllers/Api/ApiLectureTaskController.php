<?php

namespace App\Http\Controllers\Api;

use App\Models\LectureTask;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\LectureTaskResource;
use App\Http\Requests\LectureTask\StoreLectureTaskRequest;
use App\Http\Requests\LectureTask\UpdateLectureTaskRequest;
use App\Support\Interfaces\Services\LectureTaskServiceInterface;

class ApiLectureTaskController extends ApiController {
    public function __construct(
        protected LectureTaskServiceInterface $lectureTaskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return LectureTaskResource::collection($this->lectureTaskService->getAllPaginated($request->query(), $perPage)->load(['group', 'task']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectureTaskRequest $request) {
        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_LECTURE_TASK->value:
                return $this->lectureTaskService->create($request->validated());
            case IntentEnum::API_USER_ASSIGN_TASK->value:
                return $this->lectureTaskService->assignTask($request->validated());    
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(LectureTask $lectureTask) {
        return new LectureTaskResource($lectureTask);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureTaskRequest $request, LectureTask $lectureTask) {
        return $this->lectureTaskService->update($lectureTask, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, LectureTask $lectureTask) {
        return $this->lectureTaskService->delete($lectureTask);
    }
}