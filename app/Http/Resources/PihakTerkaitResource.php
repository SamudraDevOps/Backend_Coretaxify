<?php

namespace App\Http\Resources;

use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class PihakTerkaitResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        switch ($intent) {
            case IntentEnum::API_GET_KUASA_WAJIB_SAYA->value:
                return [
                    'id' => $this->id,
                    'npwp' => $this->sistem->npwp_akun,
                    'nama_pengurus' => $this->sistem->nama_akun,
                    'id_penunjukkan_perwakilan' => $this->id_penunjukkan_perwakilan,
                ];
        }

        return [
            'id' => $this->id,
            'npwp' => $this->sistem->npwp_akun,
            'nama_pengurus' => $this->sistem->nama_akun,
            'jenis_orang_terkait' => $this->jenis_orang_terkait,
            'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
            'kewarganegaraan' => $this->kewarganegaraan,
            'negara_asal' => $this->negara_asal,
            'sub_orang_terkait' => $this->sub_orang_terkait,
            'id_penunjukkan_perwakilan' => $this->id_penunjukkan_perwakilan,
            'keterangan' => $this->keterangan,
            'tanggal_mulai'  => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
