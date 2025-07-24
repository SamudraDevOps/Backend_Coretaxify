<?php

namespace App\Http\Requests\Group;

use App\Support\Enums\GroupStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'nullable|string',
            'class_code' => 'nullable|string',
            'status' => 'nullable|in:' . implode(',', GroupStatusEnum::toArray()),
        ];
    }
}
