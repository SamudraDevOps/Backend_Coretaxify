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

        $intent = $request->query('jenis_spt_ppn');
        // dd($intent);
        switch($intent) {
            case JenisSptPpnEnum::A1->value:
                return [
                    'nama_pembeli' => $this->pic->nama_akun,
                    'npwp' => $this->pic->npwp_akun,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::A2->value:
                return [
                    'nama_pembeli' => $this->pic->nama_akun,
                    'npwp' => $this->pic->npwp_akun,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                    ];
            case JenisSptPpnEnum::B1->value:
                return [
                    'nama_pembeli' => $this->pic->nama_akun,
                    'npwp' => $this->pic->npwp_akun,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::B2->value:
                return [
                    'nama_pembeli' => $this->pic->nama_akun,
                    'npwp' => $this->pic->npwp_akun,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => ($this->dpp_lain ?? 0) - ($this->dpp_lain_retur ?? 0),
                    'ppn' => ($this->ppn ?? 0) - ($this->ppn_retur ?? 0),
                    'ppnbm' => ($this->ppnbm ?? 0) - ($this->ppnbm_retur ?? 0),
                ];
            case JenisSptPpnEnum::B3->value:
                return [
                    'nama_pembeli' => $this->pic->nama_akun,
                    'npwp' => $this->pic->npwp_akun,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case JenisSptPpnEnum::C->value:
                return [
                    'nama_pembeli' => $this->pic->nama_akun,
                    'npwp' => $this->pic->npwp_akun,
                    'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                    'dpp' => $this->dpp,
                    'dpp_lain' => $this->dpp_lain,
                    'ppn' => $this->ppn,
                    'ppnbm' => $this->ppnbm,
                ];
            case IntentEnum::API_GET_FAKTUR_RETUR_KELUARAN->value:
                return [
                    'id' => $this->id,
                    'badan_id' => $this->badan_id,
                    'pic_id' => $this->pic_id,
                    'akun_pengirim_id' => new SistemResource($this->akun_pengirim),
                    'akun_penerima_id' => $akunPenerimaResource,
                    'is_draft' => $this->is_draft,
                    'is_retur' => $this->is_retur,
                    'status' => $this->status,
                    'dpp' => $this->dpp,
                    'dpp_lain_retur' => $this->dpp_lain_retur,
                    'ppn_retur' => $this->ppn_retur,
                    'ppnbm_retur' => $this->ppnbm_retur,
                    'nomor_faktur_pajak' => $this->nomor_faktur_pajak,
                    'masa_pajak' => $this->masa_pajak,
                    'tahun' => $this->tahun,
                    'esign_status' => $this->esign_status,
                    'penandatangan' => $this->pic->nama_akun,
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
                                'dpp_lain_retur' => $transaksi->dpp_lain_retur,
                                'ppn_retur' => $transaksi->ppn_retur,
                                'ppnbm_retur' => $transaksi->ppnbm_retur,
                                'tarif_ppnbm' => $transaksi->tarif_ppnbm,
                            ];
                        });
                    }),
                ];
            case IntentEnum::API_GET_FAKTUR_RETUR_MASUKAN->value:
                return [
                    'id' => $this->id,
                    'badan_id' => $this->badan_id,
                    'pic_id' => $this->pic_id,
                    'akun_pengirim_id' => new SistemResource($this->akun_pengirim),
                    'akun_penerima_id' => $akunPenerimaResource,
                    'is_draft' => $this->is_draft,
                    'is_retur' => $this->is_retur,
                    'status' => $this->status,
                    'dpp' => $this->dpp,
                    'dpp_lain_retur' => $this->dpp_lain_retur,
                    'ppn_retur' => $this->ppn_retur,
                    'ppnbm_retur' => $this->ppnbm_retur,
                    'nomor_faktur_pajak' => $this->nomor_faktur_pajak,
                    'masa_pajak' => $this->masa_pajak,
                    'tahun' => $this->tahun,
                    'esign_status' => $this->esign_status,
                    'penandatangan' => $this->pic->nama_akun,
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
                                'dpp_lain_retur' => $transaksi->dpp_lain_retur,
                                'ppn_retur' => $transaksi->ppn_retur,
                                'ppnbm_retur' => $transaksi->ppnbm_retur,
                                'tarif_ppnbm' => $transaksi->tarif_ppnbm,
                            ];
                        });
                    }),
                ];
        }

        return [
            'id' => $this->id,
            'badan_id' => $this->badan_id,
            'pic_id' => $this->pic_id,
            'akun_pengirim_id' => new SistemResource($this->akun_pengirim),
            'akun_penerima_id' => $akunPenerimaResource,
            'is_draft' => $this->is_draft,
            'status' => $this->status,
            'dpp' => $this->dpp,
            'dpp_lain' => $this->dpp_lain,
            'ppn' => $this->ppn,
            'ppnbm' => $this->ppnbm,
            'dpp_lain_retur' => $this->dpp_lain_retur,
            'ppn_retur' => $this->ppn_retur,
            'ppnbm_retur' => $this->ppnbm_retur,
            'nomor_faktur_pajak' => $this->nomor_faktur_pajak,
            'masa_pajak' => $this->masa_pajak,
            'tahun' => $this->tahun,
            'esign_status' => $this->esign_status,
            'penandatangan' => $this->pic->nama_akun,
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
                        'dpp_lain_retur' => $transaksi->dpp_lain_retur,
                        'ppn_retur' => $transaksi->ppn_retur,
                        'ppnbm_retur' => $transaksi->ppnbm_retur,
                        'tarif_ppnbm' => $transaksi->tarif_ppnbm,
                    ];
                });
            }),
        ];
    }
}
