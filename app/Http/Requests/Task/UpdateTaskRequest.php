<?php

namespace App\Http\Requests\Task;

use App\Support\Enums\TaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'nullable|string',
            'import_file' => 'required|mimes:xlsx,xls,csv',
        ];
    }
}
