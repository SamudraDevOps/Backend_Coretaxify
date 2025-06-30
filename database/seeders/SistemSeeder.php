<?php

namespace Database\Seeders;

use App\Models\Sistem;
use App\Models\Account;
use App\Models\Assignment;
use App\Models\ProfilSaya;
use App\Models\DataEkonomi;
use App\Models\InformasiUmum;
use App\Models\AssignmentUser;
use Illuminate\Database\Seeder;
use App\Models\NomorIdentifikasiEksternal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignmentUser = AssignmentUser::first();
        $task_id = Assignment::where('id', $assignmentUser->assignment_id)->first()->task_id;
        $dataAccount = Account::where('task_id', $task_id)
            ->select('nama', 'npwp', 'account_type_id', 'alamat_utama', 'email')
            ->get();

        foreach ($dataAccount as $account) {
            Sistem::create([
                'assignment_user_id' => $assignmentUser->id,
                'profil_saya_id' => ProfilSaya::create([
                        'informasi_umum_id' => InformasiUmum::create([
                            'nama' => $account->nama,
                            'npwp' => $account->npwp,
                            'jenis_wajib_pajak' => $account->account_type->name,
                            'kategori_wajib_pajak' => $account->account_type->name,
                            'bahasa' => 'Bahasa Indonesia',
                        ])->id,
                        'data_ekonomi_id' => DataEkonomi::create()->id,
                        'nomor_identifikasi_eksternal_id' => NomorIdentifikasiEksternal::create([
                            'nomor_identifikasi' => $account->npwp,
                        ])->id,
                    ])->id,
                'nama_akun' => $account->nama,
                'npwp_akun' => $account->npwp,
                'tipe_akun' => $account->account_type->name,
                'alamat_utama_akun' => $account->alamat_utama,
                'email_akun' => $account->email,
                'saldo' => 0
            ]);
        }

        $assignmentUser->update([
            'is_start' => true,
        ]);

    }
}
