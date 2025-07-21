<?php

namespace App\Http\Requests\SptScore;

use Illuminate\Foundation\Http\FormRequest;

class StoreSptScoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'required|exists:sistems,id',
            'score' => 'required|integer|min:0|max:100',
        ];
    }
}
