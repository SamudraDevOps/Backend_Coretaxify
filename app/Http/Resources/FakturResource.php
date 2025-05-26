<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Support\Enums\JenisSptPpnEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class FakturResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $akunPenerimaResource = $this->is_akun_tambahan
            ? new SistemTambahanResource($this->akun_penerima_tambahan)
            : new SistemResource($this->akun_penerima);

        $intent = $request->query('intent');

        switch($intent) {
            case JenisSptPpnEnum::A1->value:
                return [
                    'nama_pembeli' => $this->akun_op->nama_akun,
                    'npwp' => $this->akun_op->npwp,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::A2->value:
                return [
                    'nama_pembeli' => $this->akun_op->nama_akun,
                    'npwp' => $this->akun_op->npwp,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                    ];
            case JenisSptPpnEnum::B1->value:
                return [
                    'nama_pembeli' => $this->akun_op->nama_akun,
                    'npwp' => $this->akun_op->npwp,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::B2->value:
                return [
                    'nama_pembeli' => $this->akun_op->nama_akun,
                    'npwp' => $this->akun_op->npwp,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::B3->value:
                return [
                    'nama_pembeli' => $this->akun_op->nama_akun,
                    'npwp' => $this->akun_op->npwp,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::C->value:
                return [
                    'nama_pembeli' => $this->akun_op->nama_akun,
                    'npwp' => $this->akun_op->npwp,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
        }

        return [
            'id' => $this->id,
            'sistem_id' => $this->sistem_id,
            'pic_id' => $this->pic_id,
            'akun_pengirim_id' => new SistemResource($this->akun_pengirim),
            'akun_penerima_id' => $akunPenerimaResource,
            'is_draft' => $this->is_draft,
            'status' => $this->status,
            'dpp' => $this->dpp,
            'dpp_lain' => $this->dpp_lain,
            'ppn' => $this->ppn,
            'ppnbm' => $this->ppnbm,
            'nomor_faktur_pajak' => $this->nomor_faktur_pajak,
            'masa_pajak' => $this->masa_pajak,
            'tahun' => $this->tahun,
            'esign_status' => $this->esign_status,
            'penandatangan' => $this->pic->akun_op->nama_akun,
            'referensi' => $this->referensi,
            'kode_transaksi' => $this->kode_transaksi,
            'informasi_tambahan' => $this->informasi_tambahan,
            'cap_fasilitas' => $this->cap_fasilitas,
            'tanggal_faktur_pajak' => $this->tanggal_faktur_pajak,
            'dilaporkan_oleh_penjual' => $this->dilaporkan_oleh_penjual,
            'dilaporkan_oleh_pemungut_ppn' => $this->dilaporkan_oleh_pemungut_ppn,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'detail_transaksi' => $this->whenLoaded('detail_transaksis', function() {
                return $this->detail_transaksis->map(function($transaksi) {
                    return [
                        'id' => $transaksi->id,
                        'tipe' => $transaksi->tipe,
                        'nama' => $transaksi->nama,
                        'kode' => $transaksi->kode,
                        'kuantitas' => $transaksi->kuantitas,
                        'satuan' => $transaksi->satuan,
                        'harga_satuan' => $transaksi->harga_satuan,
                        'total_harga' => $transaksi->total_harga,
                        'pemotongan_harga' => $transaksi->pemotongan_harga,
                        'dpp' => $transaksi->dpp,
                        'ppn' => $transaksi->ppn,
                        'dpp_lain' => $transaksi->dpp_lain,
                        'ppnbm' => $transaksi->ppnbm,
                        'tarif_ppnbm' => $transaksi->tarif_ppnbm,
                    ];
                });
            }),
        ];
    }
}
