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
                    'exam_code' => 'required|string|max:255',
                    'start_period' => 'required|datetime',
                    'end_period' => 'required|datetime',
                    'duration' => 'required|integer',
                ];
            case IntentEnum::API_USER_JOIN_EXAM->value:
                return [
                    'exam_code' => 'required|string',
                ];
        }

        return [
            'name' => 'required|string|max:255',
            'exam_code' => 'required|string|max:255',
            'start_period' => 'required|datetime',
            'end_period' => 'required|datetime',
            'duration' => 'required|integer',
            'import_file' => 'sometimes|mimes:xlsx,xls,csv',
        ];
    }
}
