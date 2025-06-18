<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ExamUser\StoreExamUserRequest;
use App\Http\Requests\ExamUser\UpdateExamUserRequest;
use App\Http\Resources\ExamUserResource;
use App\Models\ExamUser;
use App\Support\Interfaces\Services\ExamUserServiceInterface;
use Illuminate\Http\Request;

class ApiExamUserController extends ApiController {
    public function __construct(
        protected ExamUserServiceInterface $examUserService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return ExamUserResource::collection($this->examUserService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamUserRequest $request) {
        return $this->examUserService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamUser $examUser) {
        return new ExamUserResource($examUser);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamUserRequest $request, ExamUser $examUser) {
        return $this->examUserService->update($examUser, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ExamUser $examUser) {
        return $this->examUserService->delete($examUser);
    }
}
