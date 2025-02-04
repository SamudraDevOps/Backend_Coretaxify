<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest {
    public function rules(): array {
        return [
            // Add your validation rules here
        ];
    }
}