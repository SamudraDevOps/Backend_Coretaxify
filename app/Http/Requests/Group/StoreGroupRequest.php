<?php

namespace App\Http\Requests\Group;

use App\Support\Enums\GroupStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string',
            'qty_student' => 'required|integer',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after:start_time',
            'spt' => 'required|integer',
            'bupot' => 'required|integer',
            'faktur' => 'required|integer',
            'class_code' => 'required|string',
            'status' => 'required|in:' .
                implode(',', GroupStatusEnum::toArray()),
        ];
    }
}