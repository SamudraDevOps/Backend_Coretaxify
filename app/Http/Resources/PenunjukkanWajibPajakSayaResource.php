<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenunjukkanWajibPajakSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'status_pemberian_akses_portal' => $this->status_pemberian_akses_portal,
            'nama_wajib_pajak' => $this->nama_wajib_pajak,
            'npwp' => $this->npwp,
            'nomor_penunjukkan' => $this->nomor_penunjukkan,
            'status_penunjukkan' => $this->status_penunjukkan,
            'tanggal_disetujui' => $this->tanggal_disetujui,
            'tanggal_ditolak' => $this->tanggal_ditolak,
            'tanggal_dicabut' => $this->tanggal_dicabut,
            'tanggal_dibatalkan' => $this->tanggal_dibatalkan,
            'alasan' => $this->alasan,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}