<?php

namespace App\Http\Requests\BupotScore;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Enums\BupotTypeEnum;

class StoreBupotScoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'required|exists:sistems,id',
            'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
            'score' => 'required|integer|min:0|max:100',
        ];
    }
}
