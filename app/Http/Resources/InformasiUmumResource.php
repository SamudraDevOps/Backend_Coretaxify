<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InformasiUmumResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,

            'npwp' => $this->npwp,
            'jenis_wajib_pajak' => $this->jenis_wajib_pajak,
            'nama' => $this->nama,
            'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
            'negara_asal' => $this->negara_asal,
            'tanggal_keputusan_pengesahan' => $this->tanggal_keputusan_pengesahan,
            'nomor_keputusan_pengesahan_perubahan' => $this->nomor_keputusan_pengesahan_perubahan,
            'tanggal_surat_keputusasan_pengesahan_perubahan' => $this->tanggal_surat_keputusasan_pengesahan_perubahan,
            'dead_of_establishment_document_number' => $this->dead_of_establishment_document_number,
            'place_of_establishment' => $this->place_of_establishment,
            'tanggal_pendirian' => $this->tanggal_pendirian,
            'nik_notaris' => $this->nik_notaris,
            'nama_notaris' => $this->nama_notaris,
            'jenis_perusahaan' => $this->jenis_perusahaan,
            'modal_dasar' => $this->modal_dasar,
            'modal_ditempatkan' => $this->modal_ditempatkan,
            'modal_disetor' => $this->modal_disetor,
            'kewarganegaraan' => $this->kewarganegaraan,
            'bahasa' => $this->bahasa,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
