<?php

namespace Database\Seeders;

use App\Models\Bupot;
use App\Models\Sistem;
use App\Support\Enums\IntentEnum;
use App\Support\Enums\BupotTypeEnum;
use App\Support\Enums\BupotDokumenTypeEnum;
use App\Support\Enums\GenderEnum;
use App\Support\Enums\PTKPEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BupotSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sistem IDs for foreign key references
        $sistemIds = Sistem::pluck('id')->toArray();

        if (empty($sistemIds)) {
            // Create a default sistem if none exists
            $sistem = Sistem::create([
                'name' => 'Default System',
                // Add other required fields for Sistem model
            ]);
            $sistemIds = [$sistem->id];
        }

        // Create BUPOT BPPU
        $this->createBupotBPPU($sistemIds);

        // Create BUPOT BPNR
        $this->createBupotBPNR($sistemIds);

        // Create BUPOT PS
        $this->createBupotPS($sistemIds);

        // Create BUPOT PSD
        $this->createBupotPSD($sistemIds);

        // Create BUPOT BP21
        $this->createBupotBP21($sistemIds);

        // Create BUPOT BP26
        $this->createBupotBP26($sistemIds);

        // Create BUPOT BPA1
        $this->createBupotBPA1($sistemIds);

        // Create BUPOT BPA2
        $this->createBupotBPA2($sistemIds);

        // Create BUPOT BPBPT
        $this->createBupotBPBPT($sistemIds);
    }

    private function createBupotBPPU(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[0],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'npwp_akun' => '123456789012345',
            'nama_akun' => 'PT. Contoh Perusahaan',
            'nitku' => 'NITKU001',
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'nama_objek_pajak' => 'Bunga Deposito',
            'jenis_pajak' => 'PPh Pasal 23',
            'kode_objek_pajak' => '23-100-01',
            'sifat_pajak_penghasilan' => 'Final',
            'dasar_pengenaan_pajak' => 1000000,
            'tarif_pajak' => 15,
            'pajak_penghasilan' => 150000,
            'kap' => 'KAP001',
            'jenis_dokumen' => BupotDokumenTypeEnum::toArray()[0],
            'nomor_dokumen' => 'DOK001',
            'tanggal_dokumen' => '2024-01-15',
            'nitku_dokumen' => 'NITKU_DOK001',
        ]);
    }

    private function createBupotBPNR(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[1],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'npwp_akun' => '123456789012346',
            'nama_akun' => 'John Doe',
            'alamat_utama_akun' => 'Jl. Sudirman No. 123, Jakarta',
            'negara_akun' => 'Indonesia',
            'tanggal_lahir_akun' => '1990-01-01',
            'tempat_lahir_akun' => 'Jakarta',
            'nomor_paspor_akun' => 'A12345678',
            'nomor_kitas_kitap_akun' => 'KITAS001',
            'nama_objek_pajak' => 'Sewa Tanah',
            'jenis_pajak' => 'PPh Pasal 23',
            'kode_objek_pajak' => '23-100-02',
            'sifat_pajak_penghasilan' => 'Final',
            'dasar_pengenaan_pajak' => 2000000,
            'persentase_penghasilan_bersih' => 100,
            'tarif_pajak' => 10,
            'pajak_penghasilan' => 200000,
            'kap' => 'KAP002',
            'jenis_dokumen' => BupotDokumenTypeEnum::toArray()[0],
            'nomor_dokumen' => 'DOK002',
            'tanggal_dokumen' => '2024-01-15',
            'nitku_dokumen' => 'NITKU_DOK002',
        ]);
    }

    private function createBupotPS(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[2],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'nama_objek_pajak' => 'Dividen',
            'jenis_pajak' => 'PPh Pasal 23',
            'kode_objek_pajak' => '23-100-03',
            'sifat_pajak_penghasilan' => 'Final',
            'dasar_pengenaan_pajak' => 3000000,
            'tarif_pajak' => 10,
            'pajak_penghasilan' => 300000,
            'kap' => 'KAP003',
            'jenis_dokumen' => BupotDokumenTypeEnum::toArray()[0],
            'nomor_dokumen' => 'DOK003',
            'tanggal_dokumen' => '2024-01-15',
            'nitku_dokumen' => 'NITKU_DOK003',
        ]);
    }

    private function createBupotPSD(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[3],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'nama_objek_pajak' => 'Royalti',
            'jenis_pajak' => 'PPh Pasal 23',
            'kode_objek_pajak' => '23-100-04',
            'sifat_pajak_penghasilan' => 'Final',
            'dasar_pengenaan_pajak' => 4000000,
            'tarif_pajak' => 15,
            'pajak_penghasilan' => 600000,
            'kap' => 'KAP004',
            'jenis_dokumen' => BupotDokumenTypeEnum::toArray()[0],
            'nomor_dokumen' => 'DOK004',
            'tanggal_dokumen' => '2024-01-15',
            'nitku_dokumen' => 'NITKU_DOK004',
        ]);
    }

    private function createBupotBP21(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[4],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'npwp_akun' => '123456789012347',
            'nama_akun' => 'Jane Smith',
            'nitku' => 'NITKU005',
            'ptkp_akun' => PTKPEnum::toArray()[0],
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'nama_objek_pajak' => 'Honorarium',
            'jenis_pajak' => 'PPh Pasal 21',
            'kode_objek_pajak' => '21-100-01',
            'sifat_pajak_penghasilan' => 'Tidak Final',
            'bruto_2_tahun' => 24000000,
            'dasar_pengenaan_pajak' => 5000000,
            'persentase_penghasilan_bersih' => 50,
            'tarif_pajak' => 5,
            'pajak_penghasilan' => 250000,
            'kap' => 'KAP005',
            'jenis_dokumen' => BupotDokumenTypeEnum::toArray()[0],
            'nomor_dokumen' => 'DOK005',
            'tanggal_dokumen' => '2024-01-15',
            'nitku_dokumen' => 'NITKU_DOK005',
        ]);
    }

    private function createBupotBP26(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[5],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'npwp_akun' => '123456789012348',
            'nama_akun' => 'Michael Johnson',
            'alamat_utama_akun' => 'Jl. Thamrin No. 456, Jakarta',
            'negara_akun' => 'USA',
            'tanggal_lahir_akun' => '1985-06-15',
            'tempat_lahir_akun' => 'New York',
            'nomor_paspor_akun' => 'US123456789',
            'nomor_kitas_kitap_akun' => 'KITAS002',
            'nama_objek_pajak' => 'Manajemen Fee',
            'jenis_pajak' => 'PPh Pasal 26',
            'kode_objek_pajak' => '26-100-01',
            'sifat_pajak_penghasilan' => 'Final',
            'dasar_pengenaan_pajak' => 6000000,
            'persentase_penghasilan_bersih' => 100,
            'tarif_pajak' => 20,
            'pajak_penghasilan' => 1200000,
            'kap' => 'KAP006',
            'jenis_dokumen' => BupotDokumenTypeEnum::toArray()[0],
            'nomor_dokumen' => 'DOK006',
            'tanggal_dokumen' => '2024-01-15',
            'nitku_dokumen' => 'NITKU_DOK006',
        ]);
    }

        private function createBupotBPA1(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[6],
            'bekerja_di_lebih_dari_satu_pemberi_kerja' => false,
            'masa_awal' => '2024-01-01',
            'masa_akhir' => '2024-12-31',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'pegawai_asing' => false,
            'npwp_akun' => '123456789012349',
            'nama_akun' => 'Ahmad Budi',
            'alamat_utama_akun' => 'Jl. Gatot Subroto No. 789, Jakarta',
            'nomor_paspor_akun' => null,
            'negara_akun' => 'Indonesia',
            'jenis_kelamin_akun' => GenderEnum::toArray()[0],
            'ptkp_akun' => PTKPEnum::toArray()[0],
            'posisi_akun' => 'Manager',
            'nama_objek_pajak' => 'Gaji Karyawan',
            'jenis_pajak' => 'PPh Pasal 21',
            'kode_objek_pajak' => '21-100-02',
            'jenis_pemotongan' => 'Bulanan',
            'gaji_pokok_pensiun' => 8000000,
            'pembulatan_kotor' => 8000000,
            'tunjangan_pph' => 500000,
            'tunjangan_lainnya' => 1000000,
            'honorarium_imbalan_lainnya' => 0,
            'premi_asuransi_pemberi_kerja' => 200000,
            'natura_pph_pasal_21' => 0,
            'tantiem_bonus_gratifikasi_jasa_thr' => 2000000,
            'dasar_pengenaan_pajak' => 11700000,
            'biaya_jabatan' => 500000,
            'iuran_pensiun' => 100000,
            'sumbangan_keagamaan_pemberi_kerja' => 0,
            'jumlah_pengurangan' => 600000,
            'jumlah_penghasilan_neto' => 11100000,
            'nomor_bpa1_sebelumnya' => null,
            'penghasilan_neto_sebelumnya' => null,
            'penghasilan_neto_pph_pasal_21' => 11100000,
            'penghasilan_tidak_kena_pajak' => 6000000,
            'penghasilan_kena_pajak' => 5100000,
            'pph_pasal_21_penghasilan_kena_pajak' => 255000,
            'pph_pasal_21_terutang' => 255000,
            'pph_pasal_21_potongan_bpa1_sebelumnya' => null,
            'pph_pasal_21_terutang_bupot_ini' => 255000,
            'pph_pasal_21_ditanggung_pemerintah' => null,
            'pph_pasal_21_masa_pajak_terakhir' => null,
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'kap' => 'KAP007',
            'nitku' => 'NITKU007',
        ]);
    }

    private function createBupotBPA2(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[7],
            'bekerja_di_lebih_dari_satu_pemberi_kerja' => false,
            'masa_awal' => '2024-01-01',
            'masa_akhir' => '2024-12-31',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'npwp_akun' => '123456789012350',
            'nama_akun' => 'Sari Dewi',
            'alamat_utama_akun' => 'Jl. HR Rasuna Said No. 321, Jakarta',
            'nip_akun' => '199001012018012001',
            'jenis_kelamin_akun' => GenderEnum::toArray()[1] ?? GenderEnum::toArray()[0],
            'pangkat_golongan_akun' => 'III/c',
            'ptkp_akun' => PTKPEnum::toArray()[1] ?? PTKPEnum::toArray()[0],
            'posisi_akun' => 'PNS',
            'nama_objek_pajak' => 'Gaji PNS',
            'jenis_pajak' => 'PPh Pasal 21',
            'kode_objek_pajak' => '21-100-03',
            'jenis_pemotongan' => 'Bulanan',
            'gaji_pokok_pensiun' => 5000000,
            'tunjangan_istri' => 200000,
            'tunjangan_anak' => 100000,
            'tunjangan_perbaikan_penghasilan' => 1000000,
            'tunjangan_struktural_fungsional' => 800000,
            'tunjangan_beras' => 150000,
            'tunjangan_lainnya' => 300000,
            'penghasilan_tetap_lainnya' => 0,
            'biaya_jabatan' => 375000,
            'iuran_pensiun' => 200000,
            'sumbangan_keagamaan_pemberi_kerja' => 0,
            'jumlah_pengurangan' => 575000,
            'jumlah_penghasilan_neto' => 6975000,
            'nomor_bpa1_sebelumnya' => null,
            'penghasilan_neto_sebelumnya' => null,
            'penghasilan_neto_pph_pasal_21' => 6975000,
            'penghasilan_tidak_kena_pajak' => 5400000,
            'penghasilan_kena_pajak' => 1575000,
            'pph_pasal_21_penghasilan_kena_pajak' => 78750,
            'pph_pasal_21_terutang' => 78750,
            'pph_pasal_21_potongan_bpa1_sebelumnya' => null,
            'pph_pasal_21_terutang_bupot_ini' => 78750,
            'pph_pasal_21_ditanggung_pemerintah' => null,
            'pph_pasal_21_masa_pajak_terakhir' => null,
            'kap' => 'KAP008',
            'nitku' => 'NITKU008',
        ]);
    }

    private function createBupotBPBPT(array $sistemIds): void
    {
        Bupot::create([
            'pembuat_id' => $sistemIds[array_rand($sistemIds)],
            'representatif_id' => $sistemIds[array_rand($sistemIds)],
            'tipe_bupot' => BupotTypeEnum::toArray()[8],
            'masa_awal' => '2024-01-01',
            'status' => 'normal',
            'status_penerbitan' => 'published',
            'pegawai_asing' => true,
            'npwp_akun' => '123456789012351',
            'nama_akun' => 'David Wilson',
            'alamat_utama_akun' => 'Jl. Kuningan No. 654, Jakarta',
            'nomor_paspor_akun' => 'GB987654321',
            'negara_akun' => 'United Kingdom',
            'ptkp_akun' => PTKPEnum::toArray()[0],
            'posisi_akun' => 'Expat Manager',
            'fasilitas_pajak' => 'Tidak ada fasilitas',
            'nama_objek_pajak' => 'Gaji Tenaga Ahli Asing',
            'jenis_pajak' => 'PPh Pasal 21',
            'kode_objek_pajak' => '21-100-04',
            'dasar_pengenaan_pajak' => 15000000,
            'tarif_pajak' => 25,
            'pajak_penghasilan' => 3750000,
            'kap' => 'KAP009',
            'nitku' => 'NITKU009',
        ]);
    }
}
