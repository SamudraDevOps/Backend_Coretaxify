<?php

namespace App\Http\Requests\BupotObjekPajak;

use App\Support\Enums\BupotTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreBupotObjekPajakRequest extends FormRequest {
    public function rules(): array {
        return [
            // Add your validation rules here
            'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
            'nama_objek_pajak' => 'required|string|max:255',
            'jenis_pajak' => 'required|string|max:255',
            'kode_objek_pajak' => 'required|string|max:255',
            'tarif_pajak' => 'required|numeric|min:0',
        ];
    }
}
