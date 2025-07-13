<?php

namespace App\Http\Requests\Assignment;

use App\Support\Enums\IntentEnum;
use App\Support\Enums\AssignmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest {
    public function rules(): array {

        $intent = $this->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_ASSIGNMENT->value:
                return [
                    'groups' => 'sometimes|array',
                    'task_id' => 'required|exists:tasks,id',
                    'name' => 'required|string',
                    // 'assignment_code' => 'required|string',
                    'start_period' => 'sometimes|date_format:Y-m-d H:i:s',
                    'end_period' => 'sometimes|date_format:Y-m-d H:i:s',
                    'supporting_file' => 'sometimes|file',
                ];
            case IntentEnum::API_USER_JOIN_ASSIGNMENT->value:
                return [
                    'assignment_code' => 'required|string',
                ];
            case IntentEnum::API_USER_CREATE_EXAM->value:
                return [
                    'name' => 'required|string|max:255',
                    'task_id' => 'required|exists:tasks,id',
                    'assignment_code' => 'required|string|max:255',
                    'start_period' => 'required|date_format:Y-m-d H:i:s',
                    'end_period' => 'required|date_format:Y-m-d H:i:s',
                    'duration' => 'required|integer',
                    // 'import_file' => 'sometimes|mimes:xlsx,xls,csv',
                    'supporting_file' => 'sometimes|file',
                ];
            case IntentEnum::API_USER_JOIN_EXAM->value:
                return [
                    'assignment_code' => 'required|string',
                ];
            default:
                return [
                    'groups' => 'sometimes|array',
                    'task_id' => 'required|exists:tasks,id',
                    'name' => 'required|string',
                    // 'assignment_code' => 'required|string',
                    'start_period' => 'sometimes|date',
                    'end_period' => 'sometimes|date',
                    'supporting_file' => 'sometimes|file',
                ];
        }

    }
}
