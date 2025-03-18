<?php

namespace App\Http\Resources;

use Barryvdh\Reflection\DocBlock\Type\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'informasi_umum' => new InformasiUmumResource($this->informasi_umum),
            'data_ekonomi' => new DataEkonomiResource($this->data_ekonomi),
            'detail_bank' => new DetailBankResource($this->detail_bank),
            'nomor_identifikasi_eksternal' => new NomorIdentifikasiEksternalResource($this->nomor_identifikasi_eksternal),
            'penunjukkan_wajib_pajak_saya' => new PenunjukkanWajibPajakSayaResource($this->penunjukkan_wajib_pajak_saya),
            'jenis_pajak' => new JenisPajakResource($this->jenis_pajak),
            'objek_pajak_bumi_dan_bangunan' => new ObjekPajakBumiDanBangunanResource($this->objek_pajak_bumi_dan_bangunan),
            'detail_kontak' => DetailKontakResource::collection($this->detail_kontaks),
            'tempat_kegiatan_usaha' => TempatKegiatanUsahaResource::collection($this->tempat_kegiatan_usaha),
            'pihak_terkait' => new PihakTerkaitResource($this->pihak_terkait),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
