<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id',
            'name' => 'required|string',
            'qty_student' => 'required|integer',
            'start_period' => 'required|date_format:H:i',
            'end_period' => 'required|date_format:H:i|after:start_time',
            'spt' => 'required|integer',
            'bupot' => 'required|integer',
            'faktur' => 'required|integer',
            'purchase_code' => 'required|string',
        ];
    }
}