<?php

namespace App\Http\Requests\Contract;

use App\Support\Enums\ContractTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest {
    public function rules(): array {
        return [
            'university_id' => 'required|exists:universities,id',
            'contract_type' => ['required', 'in:' . implode(',', array_column(ContractTypeEnum::cases(), 'value'))],
            'qty_student' => 'required|integer',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after:start_time',
            'spt' => 'required|integer',
            'bupot' => 'required|integer',
            'faktur' => 'required|integer',
        ];
    }
}