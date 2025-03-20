<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitPajakKeluargaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'nik_anggota_keluarga' => $this->nik_anggota_keluarga,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'nomor_kartu_keluarga' => $this->nomor_kartu_keluarga,
            'nama_anggota_keluarga' => $this->nama_anggota_keluarga,
            'status_hubungan_keluarga' => $this->status_hubungan_keluarga,
            'pekerjaan' => $this->pekerjaan,
            'status_unit_perpajakan' => $this->status_unit_perpajakan,
            'status_ptkp' => $this->status_ptkp,
            'tanggal_lahir' => $this->tanggal_lahir,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
