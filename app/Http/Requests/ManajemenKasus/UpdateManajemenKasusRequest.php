<?php

namespace App\Http\Requests\ManajemenKasus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManajemenKasusRequest extends FormRequest {
    public function rules(): array {
        return [
            'profil_saya_id' => 'nullable|exists:profil_sayas,id', 
            'kanal' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|date',
        ];
    }
}