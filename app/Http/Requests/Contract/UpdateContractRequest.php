<?php

namespace App\Http\Requests\Contract;

use App\Support\Enums\ContractTypeEnum;
use App\Support\Enums\ContractStatusEnum;
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
            'is_buy_task' => 'required|integer',
            'status' => 'required|in:' . implode(',', array_column(ContractStatusEnum::cases(), 'value')),
            'tasks' => 'required|array',
        ];
    }
}
