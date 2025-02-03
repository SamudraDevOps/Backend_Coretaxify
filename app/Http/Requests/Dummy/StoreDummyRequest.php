<?php

namespace App\Http\Requests\Dummy;

use Illuminate\Foundation\Http\FormRequest;

class StoreDummyRequest extends FormRequest {
    public function rules(): array {
        return [
            // Add your validation rules here
        ];
    }
}