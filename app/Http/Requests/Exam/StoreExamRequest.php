<?php

namespace App\Http\Requests\Exam;

use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest {
    public function rules(): array {
        $intent = $this->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_EXAM->value:
                return [
                    'name' => 'required|string|max:255',
                    'task_id' => 'required|exists:tasks,id',
                    'exam_code' => 'required|string|max:255',
                    'start_period' => 'required|date',
                    'end_period' => 'required|date',
                    'duration' => 'required|integer',
                    // 'import_file' => 'sometimes|mimes:xlsx,xls,csv',
                    'supporting_file' => 'sometimes|file',
                ];
            case IntentEnum::API_USER_JOIN_EXAM->value:
                return [
                    'exam_code' => 'required|string',
                ];
        }

        return [
            'name' => 'required|string|max:255',
            'task_id' => 'required|exists:tasks,id',
            'exam_code' => 'required|string|max:255',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'duration' => 'required|integer',
            // 'import_file' => 'sometimes|mimes:xlsx,xls,csv',
            'supporting_file' => 'sometimes|file',
        ];
    }
}
