<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlamatWajibPajakResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'negara' => $this->negara,
            'jenis_alamat' => $this->jenis_alamat,
            'detail_alamat' => $this->detail_alamat,
            'is_lokasi_disewa' => $this->is_lokasi_disewa,
            'npwp_pemilik_tempat_sewa' => $this->npwp_pemilik_tempat_sewa,
            'nama_pemilik_tempat_sewa' => $this->nama_pemilik_tempat_sewa,
            'tanggal_mulai_sewa' => $this->tanggal_mulai_sewa,
            'tanggal_berakhir_sewa' => $this->tanggal_berakhir_sewa,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'kode_kpp' => $this->kode_kpp,
            'kpp' => $this->kpp,
            'seksi_pengawasan' => $this->seksi_pengawasan,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}