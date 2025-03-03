<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WakilSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'npwp' => $this->npwp,
            'jenis_perwakilan' => $this->jenis_perwakilan,
            'id_penunjukkan_perwakilan' => $this->id_penunjukkan_perwakilan,
            'nomor_dokumen_penunjukkan_perwakilan' => $this->nomor_dokumen_penunjukkan_perwakilan,
            'izin_perwakilan' => $this->izin_perwakilan,
            'status_penujukkan' => $this->status_penujukkan,
            'tanggal_disetujui' => $this->tanggal_disetujui,
            'tanggal_ditolak' => $this->tanggal_ditolak,
            'tanggal_dicabut' => $this->tanggal_dicabut,
            'tanggal_dibatalkan' => $this->tanggal_dibatalkan,
            'alasan' => $this->alasan,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}