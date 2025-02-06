<?php

namespace App\Http\Requests\Group;

use App\Support\Enums\GroupStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'nullable|string',
            'qty_student' => 'nullable|integer',
            'start_period' => 'nullable|date',
            'end_period' => 'nullable|date|after:start_time',
            'spt' => 'nullable|integer',
            'bupot' => 'nullable|integer',
            'faktur' => 'nullable|integer',
            'class_code' => 'nullable|string',
            'status' => 'nullable|in:' .
                implode(',', GroupStatusEnum::toArray()),
        ];
    }
}