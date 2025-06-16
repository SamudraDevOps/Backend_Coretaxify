<?php

namespace App\Http\Requests\Bupot;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class TerbitBupotRequest extends FormRequest {
    public function rules(): array {
        return [
            // Add your validation rules here
            'ids' => 'required|array'
        ];
    }
}
