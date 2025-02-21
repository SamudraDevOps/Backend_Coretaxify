<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KuasaWajibPajakResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
 
            'is_wajib_pajak' => $this->is_wajib_pajak,
            'id_penunjukkan_perwakilan' => $this->id_penunjukkan_perwakilan,
            'npwp_perwakilan' => $this->npwp_perwakilan,
            'nama_wakil' => $this->nama_wakil,
            'jenis_perwakilan' => $this->jenis_perwakilan,
            'nomor_dokumen_penunjukkan_perwakilan' => $this->nomor_dokumen_penunjukkan_perwakilan,
            'izin_perwakilan' => $this->izin_perwakilan,
            'status_penunjukkan' => $this->status_penunjukkan,
            'tanggal_disetujui' => $this->tanggal_disetujui,
            'tanggal_ditolak' => $this->tanggal_ditolak,
            'tanggal_dicabut' => $this->tanggal_dicabut,
            'tanggal_dibatalkan' => $this->tanggal_dibatalkan,
            'tanggal_tertunda' => $this->tanggal_tertunda,
            'alasan' => $this->alasan,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}