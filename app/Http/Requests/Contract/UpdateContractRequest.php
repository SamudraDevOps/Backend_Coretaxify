<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'nullable|exist:user,id',
            'name' => 'nullable|string',
            'qty_student' => 'nullable|integer',
            'start_period' => 'nullable|date_format:H:i',
            'end_period' => 'nullable|date_format:H:i|after:start_time',
            'spt' => 'nullable|integer',
            'bupot' => 'nullable|integer',
            'faktur' => 'nullable|integer',
            'purchase_code' => 'nullable|string',
        ];
    }
}