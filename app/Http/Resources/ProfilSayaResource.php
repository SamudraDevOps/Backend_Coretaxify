<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfilSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'informasi_umum' => InformasiUmumResource::collection($this->informasi_umums),
            'alamat_wajib_pajak' => AlamatWajibPajakResource::collection($this->alamat_wajib_pajaks),
            'data_ekonomi' => DataEkonomiResource::collection($this->data_ekonomis),
            'manajemen_kasus' => ManajemenKasusResource::collection($this->manajemen_kasuses),
            'detail_bank' => DetailBankResource::collection($this->detail_banks),
            'nomor_identifikasi_eksternal' => NomorIdentifikasiEksternalResource::collection($this->nomor_identifikasi_eksternals),
            'penunjukkan_wajib_pajak_saya' => PenunjukkanWajibPajakSayaResource::collection($this->penunjukkan_wajib_pajak_sayas),
            'jenis_pajak' => JenisPajakResource::collection($this->jenis_pajaks),
            'objek_pajak_bumi_dan_bangunan' => ObjekPajakBumiDanBangunanResource::collection($this->objek_pajak_bumi_dan_bangunans),
            'detail_kontak' => DetailKontakResource::collection($this->detail_kontaks),
            'kode_klu' => KodeKluResource::collection($this->kode_klus),
            'tempat_kegiatan_usaha' => TempatKegiatanUsahaResource::collection($this->tempat_kegiatan_usahas),
            'pihak_terkait' => PihakTerkaitResource::collection($this->pihak_terkaits),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}