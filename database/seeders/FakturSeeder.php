<?php

namespace Database\Seeders;

use App\Models\Faktur;
use App\Models\DetailTransaksi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FakturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {

            $nomorFakturPajak = sprintf('%02d-0-%04d', $i, 4444 + $i); // contoh: 01-0-4445, 02-0-4446, dst

            if ($i >= 11){
                $picId = 2;
                $akunPengirimId = 3;
                $akunPenerimaId = 2;
                $kodeTransaksi = (string) $i - 10;
            }else{
                $picId = 1;
                $akunPengirimId = 2;
                $akunPenerimaId = 1;
                $kodeTransaksi = (string) $i;
            }

            $faktur = Faktur::create([
                'pic_id' => $picId,
                'sistem_id' => 2,
                'akun_pengirim_id' => $akunPengirimId,
                'akun_penerima_id' => $akunPenerimaId,
                'masa_pajak' => 'April',
                'tahun' => '2023',
                'referensi' => 'PO-2023-04-001',
                'kode_transaksi' => $kodeTransaksi,
                'nomor_faktur_pajak' => $nomorFakturPajak,
                'informasi_tambahan' => null,
                'cap_fasilitas' => null,
                'tanggal_faktur_pajak' => '2023-04-15',
                'status' => 'APPROVED',
                'dilaporkan_oleh_penjual' => false,
                'dilaporkan_oleh_pemungut_ppn' => false,
                'is_draft' => false,
                'is_akun_tambahan' => false,
                'is_kredit' => true,
                'dpp' => 30000,
                'dpp_lain' => 30000,
                'ppn' => 30000,
                'ppnbm' => 30000,
            ]);

            $details = [
                [
                    'tipe' => 'Barang',
                    'nama' => 'Laptop Dell XPS 13',
                    'kode' => 'LPT001',
                    'kuantitas' => '2',
                    'satuan' => 'Unit',
                    'harga_satuan' => 125000,
                    'total_harga' => 250000,
                    'pemotongan_harga' => 10000,
                    'dpp' => 240000,
                    'ppn' => 24000,
                    'dpp_lain' => 0,
                    'ppnbm' => 0,
                    'tarif_ppnbm' => 0,
                ],
            ];

            foreach ($details as $detail) {
                $detail['faktur_id'] = $faktur->id;
                DetailTransaksi::create($detail);
            }
        }

        $faktur = Faktur::create([
                'pic_id' => 3,
                'sistem_id' => 4,
                'akun_pengirim_id' => 5,
                'akun_penerima_id' => 4,
                'masa_pajak' => 'April',
                'tahun' => '2023',
                'referensi' => 'PO-2023-04-001',
                'kode_transaksi' => $kodeTransaksi,
                'nomor_faktur_pajak' => $nomorFakturPajak,
                'informasi_tambahan' => null,
                'cap_fasilitas' => null,
                'tanggal_faktur_pajak' => '2023-04-15',
                'status' => 'APPROVED',
                'dilaporkan_oleh_penjual' => false,
                'dilaporkan_oleh_pemungut_ppn' => false,
                'is_draft' => false,
                'is_akun_tambahan' => false,
                'is_kredit' => true,
                'dpp' => 999999,
                'dpp_lain' => 300009,
                'ppn' => 300009,
                'ppnbm' => 300009,
            ]);

            $details = [
                [
                    'tipe' => 'Barang',
                    'nama' => 'Laptop Dell XPS 13',
                    'kode' => 'LPT001',
                    'kuantitas' => '2',
                    'satuan' => 'Unit',
                    'harga_satuan' => 125000,
                    'total_harga' => 250000,
                    'pemotongan_harga' => 10000,
                    'dpp' => 240000,
                    'ppn' => 24000,
                    'dpp_lain' => 0,
                    'ppnbm' => 0,
                    'tarif_ppnbm' => 0,
                ],
            ];

            foreach ($details as $detail) {
                $detail['faktur_id'] = $faktur->id;
                DetailTransaksi::create($detail);
            }

    }
}
