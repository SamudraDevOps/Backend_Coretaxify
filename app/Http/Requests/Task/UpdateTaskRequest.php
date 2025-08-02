<?php

namespace App\Http\Requests\Task;

use App\Support\Enums\TaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'sometimes|string',
            'status' => 'sometimes|in:' . implode(',', ['active', 'inactive']),
            'import_file' => 'sometimes|mimes:xlsx,xls,csv',
        ];
    }
}
