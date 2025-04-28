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
        for ($i = 1; $i <= 10; $i++) {
            $kodeTransaksi = (string) $i; // atau sesuai format yang kamu mau
            $nomorFakturPajak = sprintf('%02d-0-%04d', $i, 4444 + $i); // contoh: 01-0-4445, 02-0-4446, dst

            $faktur = Faktur::create([
                'pic_id' => 1,
                'akun_pengirim_id' => 2,
                'akun_penerima_id' => 1,
                'masa_pajak' => 'April',
                'tahun' => '2023',
                'esign_status' => 'Belum Ditandatangani',
                'penandatangan' => 'John Doe',
                'referensi' => 'PO-2023-04-001',
                'kode_transaksi' => $kodeTransaksi,
                'nomor_faktur_pajak' => $nomorFakturPajak,
                'informasi_tambahan' => null,
                'cap_fasilitas' => null,
                'tanggal_faktur_pajak' => '2023-04-15',
                'status' => 'APPROVED',
                'dilaporkan_oleh_penjual' => false,
                'dilaporkan_oleh_pemungut_ppn' => false,
                'is_draft' => 0,
                'is_akun_tambahan' => false,
                'is_kredit' => false,
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

        // $faktur = Faktur::create([
        //     'pic_id' => 1,
        //     'akun_pengirim_id' => 2,
        //     'akun_penerima_id' => 1,
        //     'masa_pajak' => 'April',
        //     'tahun' => '2023',
        //     'esign_status' => 'Belum Ditandatangani',
        //     'penandatangan' => 'John Doe',
        //     'referensi' => 'PO-2023-04-001',
        //     'kode_transaksi' => '2',
        //     'nomor_faktur_pajak' => '02-0-1111',
        //     'informasi_tambahan' => null,
        //     'cap_fasilitas' => null,
        //     'tanggal_faktur_pajak' => '2023-04-15',
        //     'status' => 'APPROVED',
        //     'dilaporkan_oleh_penjual' => false,
        //     'dilaporkan_oleh_pemungut_ppn' => false,
        //     'is_akun_tambahan' => false,
        //     'is_kredit' => false,
        //     'dpp' => 10000,
        //     'dpp_lain' => 10000,
        //     'ppn' => 10000,
        //     'ppnbm' => 10000,
        // ]);

        //     $details = [
        //         [
        //             'tipe' => 'Barang',
        //             'nama' => 'Laptop Dell XPS 13',
        //             'kode' => 'LPT001',
        //             'kuantitas' => '2',
        //             'satuan' => 'Unit',
        //             'harga_satuan' => 125000,
        //             'total_harga' => 250000,
        //             'pemotongan_harga' => 10000,
        //             'dpp' => 240000,
        //             'ppn' => 24000,
        //             'dpp_lain' => 0,
        //             'ppnbm' => 0,
        //             'tarif_ppnbm' => 0,
        //         ],
        //         [
        //             'tipe' => 'Jasa',
        //             'nama' => 'Instalasi Software',
        //             'kode' => 'SVC001',
        //             'kuantitas' => '2',
        //             'satuan' => 'Jam',
        //             'harga_satuan' => 5000,
        //             'total_harga' => 10000,
        //             'pemotongan_harga' => 0,
        //             'dpp' => 10000,
        //             'ppn' => 1000,
        //             'dpp_lain' => 0,
        //             'ppnbm' => 0,
        //             'tarif_ppnbm' => 0,
        //         ]
        //     ];

        // foreach ($details as $detail) {
        //     $detail['faktur_id'] = $faktur->id;
        //     DetailTransaksi::create($detail);
        // }

        // $faktur3 = Faktur::create([
        //     'pic_id' => 1,
        //     'akun_pengirim_id' => 2,
        //     'akun_penerima_id' => 3,
        //     'masa_pajak' => 'April',
        //     'tahun' => '2023',
        //     'esign_status' => 'Belum Ditandatangani',
        //     'penandatangan' => 'John Doe',
        //     'referensi' => 'PO-2023-04-001',
        //     'kode_transaksi' => '2',
        //     'nomor_faktur_pajak' => '02-0-3333',
        //     'informasi_tambahan' => null,
        //     'cap_fasilitas' => null,
        //     'tanggal_faktur_pajak' => '2023-04-15',
        //     'status' => 'APPROVED',
        //     'dilaporkan_oleh_penjual' => false,
        //     'dilaporkan_oleh_pemungut_ppn' => false,
        //     'is_akun_tambahan' => false,
        //     'is_kredit' => false,
        //     'dpp' => 20000,
        //     'dpp_lain' => 20000,
        //     'ppn' => 20000,
        //     'ppnbm' => 20000,
        // ]);

        //     $details3 = [
        //         [
        //             'tipe' => 'Barang',
        //             'nama' => 'Laptop Dell XPS 13',
        //             'kode' => 'LPT001',
        //             'kuantitas' => '2',
        //             'satuan' => 'Unit',
        //             'harga_satuan' => 125000,
        //             'total_harga' => 250000,
        //             'pemotongan_harga' => 10000,
        //             'dpp' => 240000,
        //             'ppn' => 24000,
        //             'dpp_lain' => 0,
        //             'ppnbm' => 0,
        //             'tarif_ppnbm' => 0,
        //         ],
        //     ];

        // foreach ($details3 as $detail) {
        //     $detail['faktur_id'] = $faktur3->id;
        //     DetailTransaksi::create($detail);
        // }

        // $faktur2 = Faktur::create([
        //     'pic_id' => 1,
        //     'akun_pengirim_id' => 2,
        //     'akun_penerima_id' => 1,
        //     'masa_pajak' => 'April',
        //     'tahun' => '2023',
        //     'esign_status' => 'Belum Ditandatangani',
        //     'penandatangan' => 'John Doe',
        //     'referensi' => 'PO-2023-04-001',
        //     'kode_transaksi' => '3',
        //     'nomor_faktur_pajak' => '03-0-4444',
        //     'informasi_tambahan' => null,
        //     'cap_fasilitas' => null,
        //     'tanggal_faktur_pajak' => '2023-04-15',
        //     'status' => 'APPROVED',
        //     'dilaporkan_oleh_penjual' => false,
        //     'dilaporkan_oleh_pemungut_ppn' => false,
        //     'is_akun_tambahan' => false,
        //     'is_kredit' => false,
        //     'dpp' => 30000,
        //     'dpp_lain' => 30000,
        //     'ppn' => 30000,
        //     'ppnbm' => 30000,
        // ]);

        //     $details2 = [
        //         [
        //             'tipe' => 'Barang',
        //             'nama' => 'Laptop Dell XPS 13',
        //             'kode' => 'LPT001',
        //             'kuantitas' => '2',
        //             'satuan' => 'Unit',
        //             'harga_satuan' => 125000,
        //             'total_harga' => 250000,
        //             'pemotongan_harga' => 10000,
        //             'dpp' => 240000,
        //             'ppn' => 24000,
        //             'dpp_lain' => 0,
        //             'ppnbm' => 0,
        //             'tarif_ppnbm' => 0,
        //         ],
        //     ];

        // foreach ($details2 as $detail) {
        //     $detail['faktur_id'] = $faktur2->id;
        //     DetailTransaksi::create($detail);
        // }
    }
}
