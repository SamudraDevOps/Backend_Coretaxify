<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\Enums\IntentEnum;
class SistemResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        
        switch ($intent) {
            case IntentEnum::API_GET_SISTEM_ALAMAT->value:
                return [
                    'id' => $this->id,
                    'alamat_utama_akun' => $this->alamat_utama_akun,
                ];
            case IntentEnum::API_SISTEM_GET_AKUN_ORANG_PIBADI->value:
                return [
                    'id' => $this->id,
                    'nama_akun' => $this->nama_akun,
                    'npwp_akun' => $this->npwp_akun,
                    'tipe_akun' => $this->tipe_akun,
                    'alamat_utama_akun' => $this->alamat_utama_akun,
                ];
            case IntentEnum::API_GET_ASSIGNMENT_USER_PIC->value:
                return [
                    'nama_akun' => $this->nama_akun,
                    'npwp_akun' => $this->npwp_akun,
                    'tipe_akun' => $this->tipe_akun,
                ];
            case IntentEnum::API_GET_SISTEM_IKHTISAR_PROFIL->value:
                return  [
                    'id' => $this->id,
                    'nama_akun' => $this->nama_akun,
                    'npwp_akun' => $this->npwp_akun,
                    'tipe_akun' => $this->tipe_akun,
                    'alamat_utama_akun' => $this->alamat_utama_akun,
                    'email_akun' => $this->email_akun,
                ];
            case IntentEnum::API_GET_SISTEM_INFORMASI_UMUM->value:
                return  [
                    'id' => $this->id,
                    'nama_akun' => $this->nama_akun,
                    'npwp_akun' => $this->npwp_akun,
                    'tipe_akun' => $this->tipe_akun,
                    'alamat_utama_akun' => $this->alamat_utama_akun,
                    'email_akun' => $this->email_akun,
                ];
        }
        return [
            'id' => $this->id,
            'assignment_user' => $this->assignment_user,
            'portal_saya' => new PortalSayaResource($this->portal_saya),
            'nama_akun' => $this->nama_akun,
            'npwp_akun' => $this->npwp_akun,
            'tipe_akun' => $this->tipe_akun,
            'alamat_utama_akun' => $this->alamat_utama_akun,
            'email_akun' => $this->email_akun,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
