<?php

namespace App\Http\Requests\Bupot;

use Illuminate\Foundation\Http\FormRequest;

class HapusBupotRequest extends FormRequest {
    public function rules(): array {
        return [
            // Add your validation rules here
            'id' => 'required|array'
        ];
    }
}
