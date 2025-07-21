<?php

namespace App\Http\Requests\FakturScore;

use App\Support\Enums\FakturTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFakturScoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'nullable|exists:sistems,id',
            'tipe_faktur' => 'nullable|in:' . implode(',', FakturTypeEnum::toArray()),
            'score' => 'nullable|integer|min:0|max:100',
        ];
    }
}
