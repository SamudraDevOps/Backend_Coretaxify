<?php

namespace App\Http\Requests\Assignment;

use App\Support\Enums\AssignmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest {
    public function rules(): array {
        return [
            'groups' => 'sometimes|array',
            'task_id' => 'required|exists:tasks,id',
            'name' => 'required|string',
            'assignment_code' => 'required|string',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'supporting_file' => 'nullable|file',
        ];
    }
}
