<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string',
            'qty_student' => 'required|integer',
            'start_period' => 'required|date_format:H:i',
            'end_period' => 'required|date_format:H:i|after:start_time',
            'spt' => 'required|integer',
            'bupot' => 'required|integer',
            'faktur' => 'required|integer',
            'class_code' => 'required|string',
            'status' => 'required|string',
        ];
    }
}