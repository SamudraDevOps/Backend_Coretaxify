<?php

namespace App\Http\Requests\Assignment;

use App\Support\Enums\AssignmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest {
    public function rules(): array {
        return [
            // 'groups' => 'sometimes|array',
            'task_id' => 'sometimes|exists:tasks,id',
            'name' => 'sometimes|string',
            'assignment_code' => 'sometimes|string',
            'start_period' => 'sometimes|date',
            'end_period' => 'sometimes|date',
            'supporting_file' => 'sometimes|file',
        ];
    }
}
