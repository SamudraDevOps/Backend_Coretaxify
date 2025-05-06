<?php

namespace App\Http\Requests\Bupot;

use App\Support\Enums\BupotDokumenTypeEnum;
use App\Support\Enums\BupotTypeEnum;
use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreBupotRequest extends FormRequest {
    public function rules(): array {
        $intent = $this->get('intent');
        switch ($intent) {
            case IntentEnum::API_BUPOT_BPPU->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                    'masa_awal' => 'required|date_format:Y-m',
                    'status' => 'required|in:' . implode(',', ['normal', 'pembetulan']),
                    'npwp_akun' => 'required|string|max:255',
                    'nama_akun' => 'required|string|max:255',
                    'nitku' => 'required|string|max:255',
                    'fasilitas_pajak' => 'required|string|max:255',
                    'nama_objek_pajak' => 'required|string|max:255',
                    'jenis_pajak' => 'required|string|max:255',
                    'kode_objek_pajak' => 'required|string|max:255',
                    'sifat_pajak_penghasilan' => 'required|string|max:255',
                    'dasar_pengenaan_pajak' => 'required|numeric|min:0',
                    'tarif_pajak' => 'required|numeric|min:0',
                    'pajak_penghasilan' => 'required|numeric|min:0',
                    'kap' => 'required|string|max:255',
                    'jenis_dokumen' => 'required|in:' . implode(',', BupotDokumenTypeEnum::toArray()),
                    'nomor_dokumen' => 'required|string|max:255',
                    'tanggal_dokumen' => 'required|date',
                    'nitku_dokumen' => 'required|string|max:255',
                ];
            case IntentEnum::API_BUPOT_BPNR->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                    'masa_awal' => 'required|date_format:Y-m',
                    'status' => 'required|in:' . implode(',', ['normal', 'pembetulan']),
                    'fasilitas_pajak' => 'required|string|max:255',
                    'npwp_akun' => 'required|string|max:255',
                    'nama_akun' => 'required|string|max:255',
                    'alamat_utama_akun' => 'required|string|max:255',
                    'tanggal_lahir_akun' => 'required|date',
                    'tempat_lahir_akun' => 'required|string|max:255',
                    'nomor_paspor_akun' => 'required|string|max:255',
                    'nomor_kitas_kitap_akun' => 'required|string|max:255',
                    'nama_objek_pajak' => 'required|string|max:255',
                    'jenis_pajak' => 'required|string|max:255',
                    'kode_objek_pajak' => 'required|string|max:255',
                    'sifat_pajak_penghasilan' => 'required|string|max:255',
                    'dasar_pengenaan_pajak' => 'required|numeric|min:0',
                    'persentase_penghasilan_bersih' => 'required|numeric|min:0',
                    'tarif_pajak' => 'required|numeric|min:0',
                    'pajak_penghasilan' => 'required|numeric|min:0',
                    'kap' => 'required|string|max:255',
                    'jenis_dokumen' => 'required|in:' . implode(',', BupotDokumenTypeEnum::toArray()),
                    'nomor_dokumen' => 'required|string|max:255',
                    'tanggal_dokumen' => 'required|date',
                    'nitku_dokumen' => 'required|string|max:255',
                ];
            case IntentEnum::API_BUPOT_PS->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_PSD->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_BP21->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_BP26->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_BPA1->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_BPA2->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_BPBPT->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
            case IntentEnum::API_BUPOT_DSBP->value:
                return [
                    'pembuat_id' => 'required|exists:sistems,id',
                    'representatif_id' => 'required|exists:sistems,id',
                    'tipe_bupot' => 'required|in:' . implode(',', BupotTypeEnum::toArray()),
                ];
        }

        return [
            // Add your validation rules here
        ];
    }
}
