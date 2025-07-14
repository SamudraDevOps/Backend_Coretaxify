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

        $intent_jenis_spt_ppn = $request->query('jenis_spt_ppn');
        switch($intent_jenis_spt_ppn) {
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
                return $this->handleB2Format();
            case JenisSptPpnEnum::B3->value:
                if ($this->is_retur) {
                    // Return array dengan 2 data: original dan retur
                    return [
                        // Data original (sebelum retur)
                        [
                            'nama_pembeli' => $this->pic->nama_akun,
                            'npwp' => $this->pic->npwp_akun,
                            'faktur_pajak_nomor' => $this->nomor_faktur_pajak,
                            'faktur_pajak_tanggal' => $this->tanggal_faktur_pajak,
                            'dpp' => $this->dpp,
                            'dpp_lain' => $this->dpp_lain,
                            'ppn' => $this->ppn,
                            'ppnbm' => $this->ppnbm,
                            'type' => 'original'
                        ],
                        // Data retur (nilai negatif)
                        [
                            'nama_pembeli' => $this->pic->nama_akun,
                            'npwp' => $this->pic->npwp_akun,
                            'faktur_pajak_nomor' => $this->nomor_retur ?? $this->nomor_faktur_pajak,
                            'faktur_pajak_tanggal' => $this->tanggal_retur ?? $this->tanggal_faktur_pajak,
                            'dpp' => 0, // atau bisa pakai dpp original jika diperlukan
                            'dpp_lain' => $this->dpp_lain_retur,
                            'ppn' => $this->ppn_retur,
                            'ppnbm' => $this->ppnbm_retur,
                            'type' => 'retur'
                        ]
                    ];
                } else {
                    // Data normal (tidak retur)
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
                }
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
        }

        $intent = $request->query('intent');

        switch($intent){
            case IntentEnum::API_GET_FAKTUR_MASUKAN_BY_NOMOR_FAKTUR->value:
                return [
                    'id' => $this->id,
                    'nomor_faktur_pajak' => $this->nomor_faktur_pajak . ' - ' . $this->akun_pengirim->nama_akun,
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
                    'dilaporkan_oleh_penjual' => $this->dilaporkan_oleh_penjual,
                    'dilaporkan_oleh_pemungut_ppn' => $this->dilaporkan_oleh_pemungut_ppn,
                    'tanggal_retur' => $this->tanggal_retur,
                    'nomor_retur' => $this->nomor_retur,
                    'jumlah_dpp_retur' => '0',
                    'jumlah_dpp_lain_retur' => $this->jumlah_dpp_lain_retur,
                    'jumlah_ppn_retur' => $this->jumlah_ppn_retur,
                    'jumlah_ppnbm_retur' => $this->jumlah_ppnbm_retur,
                    'jumlah_total_bayar_retur' => $this->jumlah_total_harga_retur,
                    'jumlah_pemotongan_harga_retur' => $this->jumlah_pemotongan_harga_retur,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                    'detail_transaksi' => $this->whenLoaded('detail_transaksis', function() {
                        return $this->detail_transaksis->map(function($transaksi) {
                            return [
                                'id' => $transaksi->id,
                                'tipe' => $transaksi->tipe,
                                'nama' => $transaksi->nama,
                                'kode' => $transaksi->kode,
                                'kuantitas' => $transaksi->jumlah_barang_diretur ?? 0,
                                'satuan' => $transaksi->satuan,
                                'harga_satuan' => $transaksi->harga_satuan,
                                'total_harga' => $transaksi->total_harga_diretur ?? 0,
                                'pemotongan_harga' => $transaksi->pemotongan_harga_diretur ?? 0,
                                'dpp' => 0,
                                'dpp_lain_retur' => $transaksi->dpp_lain_retur ?? 0,
                                'ppn_retur' => $transaksi->ppn_retur ?? 0,
                                'ppnbm_retur' => $transaksi->ppnbm_retur ?? 0,
                                'tarif_ppnbm' => 0,
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
            'is_retur' => $this->is_retur,
            'is_kredit' => $this->is_kredit,
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
                    return $this->mapDetailTransaksiWithFallback($transaksi);
                });
            }),
        ];
    }

    private function handleB2Format()
    {
        $data = [];
        $dataRetur = [];

        foreach ($this->collection as $faktur) {
            // Data normal selalu masuk ke array 'data'
            $normalData = [
                'nama_pembeli' => $faktur->pic->nama_akun,
                'npwp' => $faktur->pic->npwp_akun,
                'faktur_pajak_nomor' => $faktur->nomor_faktur_pajak,
                'faktur_pajak_tanggal' => $faktur->tanggal_faktur_pajak,
                'dpp' => $faktur->dpp,
                'dpp_lain' => ($faktur->dpp_lain ?? 0),
                'ppn' => ($faktur->ppn ?? 0),
                'ppnbm' => ($faktur->ppnbm ?? 0),
            ];

            $data[] = $normalData;

            // Kalau ada retur, tambahkan ke array 'data_retur'
            if ($faktur->is_retur) {
                $returData = [
                    'nama_pembeli' => $faktur->pic->nama_akun,
                    'npwp' => $faktur->pic->npwp_akun,
                    'faktur_pajak_nomor' => $faktur->nomor_retur ?? $faktur->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $faktur->tanggal_retur ?? $faktur->tanggal_faktur_pajak,
                    'dpp' => 0,
                    'dpp_lain' => ($faktur->dpp_lain_retur ?? 0),
                    'ppn' => ($faktur->ppn_retur ?? 0),
                    'ppnbm' => ($faktur->ppnbm_retur ?? 0),
                ];

                $dataRetur[] = $returData;
            }
        }

        $result = ['data' => $data];

        if (!empty($dataRetur)) {
            $result['data_retur'] = $dataRetur;
        }

        return $result;
    }
    private function mapDetailTransaksiWithFallback($transaksi): array
    {
        return [
            'id' => $transaksi->id,
            'tipe' => $transaksi->tipe_lama ?? $transaksi->tipe,
            'nama' => $transaksi->nama_lama ?? $transaksi->nama,
            'kode' => $transaksi->kode_lama ?? $transaksi->kode,
            'kuantitas' => $transaksi->kuantitas_lama ?? $transaksi->kuantitas,
            'satuan' => $transaksi->satuan_lama ?? $transaksi->satuan,
            'harga_satuan' => $transaksi->harga_satuan_lama ?? $transaksi->harga_satuan,
            'total_harga' => $transaksi->total_harga_lama ?? $transaksi->total_harga,
            'pemotongan_harga' => $transaksi->pemotongan_harga_lama ?? $transaksi->pemotongan_harga,
            'dpp' => $transaksi->dpp_lama ?? $transaksi->dpp,
            'ppn' => $transaksi->ppn_lama ?? $transaksi->ppn,
            'dpp_lain' => $transaksi->dpp_lain_lama ?? $transaksi->dpp_lain,
            'ppnbm' => $transaksi->ppnbm_lama ?? $transaksi->ppnbm,
            'dpp_lain_retur' => $transaksi->dpp_lain_retur_lama ?? $transaksi->dpp_lain_retur,
            'ppn_retur' => $transaksi->ppn_retur_lama ?? $transaksi->ppn_retur,
            'ppnbm_retur' => $transaksi->ppnbm_retur_lama ?? $transaksi->ppnbm_retur,
            'tarif_ppnbm' => $transaksi->tarif_ppnbm_lama ?? $transaksi->tarif_ppnbm,

            // Tambahan info untuk tracking
            'is_tambahan' => $transaksi->is_tambahan ?? false,
            'is_lama' => $transaksi->is_lama ?? false,
        ];
    }
}
