<?php

namespace App\Http\Requests\University;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUniversityRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string'
        ];
    }
}