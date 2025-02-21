<?php

namespace App\Http\Requests\ManajemenKasus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManajemenKasusRequest extends FormRequest {
    public function rules(): array {
        return [
             
            'kanal' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|date',
        ];
    }
}