<?php

namespace App\Http\Resources;

use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class InformasiUmumResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        switch ($intent) {
            case IntentEnum::API_GET_SISTEM_INFORMASI_UMUM_ORANG_PRIBADI->value:
                return [
                    'id' => $this->id,
                    'npwp' => $this->npwp,
                    'jenis_wajib_pajak' => $this->jenis_wajib_pajak,
                    'nama' => $this->nama,
                    'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
                    'nomor_paspor' => $this->nomor_paspor,
                    'tempat_lahir' => $this->tempat_lahir,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'status_perkawinan' => $this->status_perkawinan,
                    'status_hubungan_keluarga' => $this->status_hubungan_keluarga,
                    'agama' => $this->agama,
                    'jenis_pekerjaan' => $this->jenis_pekerjaan,
                    'nama_ibu_kandung' => $this->nama_ibu_kandung,
                    'nomor_kartu_keluarga' => $this->nomor_kartu_keluarga,
                    'kewarganegaraan'   => $this->kewarganegaraan,
                    'bahasa' => $this->bahasa,
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
            case IntentEnum::API_GET_SISTEM_INFORMASI_UMUM_BADAN->value:
                return [
                    'id' => $this->id,
                    'alamat_wajib_pajak' => $this->profil_saya->sistem->alamat_utama_akun,
                    'npwp' => $this->npwp,
                    'jenis_wajib_pajak' => $this->jenis_wajib_pajak,
                    'nama' => $this->nama,
                    'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
                    'negara_asal' => $this->negara_asal,
                    'tanggal_keputusan_pengesahan' => $this->tanggal_keputusan_pengesahan,
                    'nomor_keputusan_pengesahan' => $this->nomor_keputusan_pengesahan,
                    'nomor_keputusan_pengesahan_perubahan' => $this->nomor_keputusan_pengesahan_perubahan,
                    'tanggal_surat_keputusasan_pengesahan_perubahan' => $this->tanggal_surat_keputusasan_pengesahan_perubahan,
                    'nomor_akta_pendirian' => $this->nomor_akta_pendirian,
                    'tempat_pendirian' => $this->tempat_pendirian,
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
            default:
                return [
                    'id' => $this->id,
                    'npwp' => $this->npwp,
                    'jenis_wajib_pajak' => $this->jenis_wajib_pajak,
                    'nama' => $this->nama,
                    'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
                    'negara_asal' => $this->negara_asal,
                    'tanggal_keputusan_pengesahan' => $this->tanggal_keputusan_pengesahan,
                    'nomor_keputusan_pengesahan' => $this->nomor_keputusan_pengesahan,
                    'nomor_keputusan_pengesahan_perubahan' => $this->nomor_keputusan_pengesahan_perubahan,
                    'tanggal_surat_keputusasan_pengesahan_perubahan' => $this->tanggal_surat_keputusasan_pengesahan_perubahan,
                    'nomor_akta_pendirian' => $this->nomor_akta_pendirian,
                    'tempat_pendirian' => $this->tempat_pendirian,
                    'tanggal_pendirian' => $this->tanggal_pendirian,
                    'nik_notaris' => $this->nik_notaris,
                    'nama_notaris' => $this->nama_notaris,
                    'jenis_perusahaan' => $this->jenis_perusahaan,
                    'modal_dasar' => $this->modal_dasar,
                    'modal_ditempatkan' => $this->modal_ditempatkan,
                    'modal_disetor' => $this->modal_disetor,
                    'nomor_paspor' => $this->nomor_paspor,
                    'tempat_lahir' => $this->tempat_lahir,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'status_perkawinan' => $this->status_perkawinan,
                    'status_hubungan_keluarga' => $this->status_hubungan_keluarga,
                    'agama' => $this->agama,
                    'jenis_pekerjaan' => $this->jenis_pekerjaan,
                    'nama_ibu_kandung' => $this->nama_ibu_kandung,
                    'nomor_kartu_keluarga' => $this->nomor_kartu_keluarga,
                    'kewarganegaraan' => $this->kewarganegaraan,
                    'bahasa' => $this->bahasa,
                    'created_at' => $this->created_at->toDateTimeString(),
                    'updated_at' => $this->updated_at->toDateTimeString(),
                ];
        }
    }
}
