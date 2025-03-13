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
            'start_period' => 'sometimes|date_format:Y-m-d H:i:s',
            'end_period' => 'sometimes|date_format:Y-m-d H:i:s',
            'supporting_file' => 'sometimes|file',
        ];
    }
}
