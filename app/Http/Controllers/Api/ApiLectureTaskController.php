<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LectureTask\StoreLectureTaskRequest;
use App\Http\Requests\LectureTask\UpdateLectureTaskRequest;
use App\Http\Resources\LectureTaskResource;
use App\Models\LectureTask;
use App\Support\Interfaces\Services\LectureTaskServiceInterface;
use Illuminate\Http\Request;

class ApiLectureTaskController extends ApiController {
    public function __construct(
        protected LectureTaskServiceInterface $lectureTaskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return LectureTaskResource::collection($this->lectureTaskService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectureTaskRequest $request) {
        return $this->lectureTaskService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(LectureTask $lectureTask) {
        return new LectureTaskResource($lectureTask->load(['roles' => ['division', 'permissions']]));
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