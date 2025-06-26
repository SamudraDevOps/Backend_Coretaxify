<?php

namespace App\Http\Requests\Assignment;

use App\Support\Enums\AssignmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest {
    public function rules(): array {
        return [
            // 'groups' => 'sometimes|array',
            'task_id' => 'nullable|exists:tasks,id',
            'name' => 'nullable|string',
            'assignment_code' => 'nullable|string',
            'start_period' => 'nullable|date_format:Y-m-d H:i:s',
            'end_period' => 'nullable|date_format:Y-m-d H:i:s',
            'supporting_file' => 'nullable|file',
        ];
    }
}
