<?php

namespace App\Http\Requests\Exam;

use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest {
    public function rules(): array {
        $intent = $this->get('intent');
        switch ($intent) {
            // case IntentEnum::API_USER_IMPORT_EXAM->value:
            //     return [
            //         'user_id' => 'required|integer|exists:users,id',
            //         'name' => 'required|string|max:255',
            //         'exam_code' => 'required|string|max:255',
            //         'start_period' => 'required|datetime',
            //         'end_period' => 'required|datetime',
            //         'duration' => 'required|integer',
            //         'import_file' => 'required|mimes:xlsx,xls,csv',
            //     ];
            default:
                return [
                    'user_id' => 'required|exists:users,id',
                    'task_id' => 'required|exists:tasks,id',
                    'name' => 'required|string|max:255',
                    'exam_code' => 'required|string|max:255',
                    'start_period' => 'required|datetime',
                    'end_period' => 'required|datetime',
                    'duration' => 'required|integer',
                ];
            }
    }
}
