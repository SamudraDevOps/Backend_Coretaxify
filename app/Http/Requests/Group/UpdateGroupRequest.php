<?php

namespace App\Http\Requests\Group;

use App\Support\Enums\GroupStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'sometimes|string',
            'qty_student' => 'sometimes|integer',
            'start_period' => 'sometimes|date',
            'end_period' => 'sometimes|date|after:start_time',
            'class_code' => 'sometimes|string',
            'status' => 'sometimes|in:' . implode(',', GroupStatusEnum::toArray()),
        ];
    }
}
