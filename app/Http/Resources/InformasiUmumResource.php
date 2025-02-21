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
            'notary_office_nik' => $this->notary_office_nik,
            'notary_office_name' => $this->notary_office_name,
            'jenis_perusahaan' => $this->jenis_perusahaan,
            'authorized_capital' => $this->authorized_capital,
            'issued_capital' => $this->issued_capital,
            'paid_in_capital' => $this->paid_in_capital,
            'kewarganegaraan' => $this->kewarganegaraan,
            'bahasa' => $this->bahasa,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}