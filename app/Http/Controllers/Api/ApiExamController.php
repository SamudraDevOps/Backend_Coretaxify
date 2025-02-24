<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\ExamResource;
use App\Http\Requests\Exam\StoreExamRequest;
use App\Http\Requests\Exam\UpdateExamRequest;
use App\Support\Interfaces\Services\ExamServiceInterface;

class ApiExamController extends ApiController {
    public function __construct(
        protected ExamServiceInterface $examService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return ExamResource::collection($this->examService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamRequest $request) {
        $intent = $request->get('intent');

        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_EXAM->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc')) {
                    return $this->examService->create($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to create a group',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_EXAM->value:
                if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
                    return $this->examService->joinExam($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to join a group',
                    ], 403);
                }
        }

        return $this->examService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Exam $exam) {
        $intent = $request->get('intent');

        switch($intent) {
            // case IntentEnum::API_USER_DOWNLOAD_SOAL->value:
            //     return $this->examService->downloadFile($exam);
            case IntentEnum::API_USER_DOWNLOAD_FILE->value:
                return $this->examService->downloadSupport($exam);
        }
        return new ExamResource($exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamRequest $request, Exam $exam) {
        return $this->examService->update($exam, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Exam $exam) {
        return $this->examService->delete($exam);
    }
}
