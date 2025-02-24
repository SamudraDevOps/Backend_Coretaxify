<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfilSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'informasi_umum' => new InformasiUmumResource($this->informasi_umums),
            'alamat_wajib_pajak' => new AlamatWajibPajakResource($this->alamat_wajib_pajaks),
            'data_ekonomi' => new DataEkonomiResource($this->data_ekonomis),
            'manajemen_kasus' => new ManajemenKasusResource($this->manajemen_kasuses),
            'detail_bank' => new DetailBankResource($this->detail_banks),
            'nomor_identifikasi_eksternal' => new NomorIdentifikasiEksternalResource($this->nomor_identifikasi_eksternals),
            'penunjukkan_wajib_pajak_saya' => new PenunjukkanWajibPajakSayaResource($this->penunjukkan_wajib_pajak_sayas),
            'jenis_pajak' => new JenisPajakResource($this->jenis_pajaks),
            'objek_pajak_bumi_dan_bangunan' => new ObjekPajakBumiDanBangunanResource($this->objek_pajak_bumi_dan_bangunans),
            'detail_kontak' => new DetailKontakResource($this->detail_kontaks),
            'kode_klu' => new KodeKluResource($this->kode_klus),
            'tempat_kegiatan_usaha' => new TempatKegiatanUsahaResource($this->tempat_kegiatan_usahas),
            'pihak_terkait' => new PihakTerkaitResource($this->pihak_terkaits),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}