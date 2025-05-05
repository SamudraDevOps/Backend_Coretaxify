<?php

namespace App\Http\Requests\BupotObjekPajak;

use App\Support\Enums\BupotTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBupotObjekPajakRequest extends FormRequest {
    public function rules(): array {
        return [
            // Add your validation rules here
            'tipe_bupot' => 'sometimes|in:' . implode(',', BupotTypeEnum::toArray()),
            'nama_objek_pajak' => 'sometimes|string|max:255',
            'jenis_pajak' => 'sometimes|string|max:255',
            'kode_objek_pajak' => 'sometimes|string|max:255',
            'tarif_pajak' => 'sometimes|numeric|min:0',
        ];
    }
}
