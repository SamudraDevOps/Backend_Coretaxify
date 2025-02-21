<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataEkonomiResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
 
            'merek_dagang' => $this->merek_dagang,
            'is_karyawan' => $this->is_karyawan,
            'jumlah_karyawan' => $this->jumlah_karyawan,
            'metode_pembukuan' => $this->metode_pembukuan,
            'mata_uang_pembukuan' => $this->mata_uang_pembukuan,
            'periode_pembukuan' => $this->periode_pembukuan,
            'omset_per_tahun' => $this->omset_per_tahun,
            'jumlah_peredaran_bruto' => $this->jumlah_peredaran_bruto,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}