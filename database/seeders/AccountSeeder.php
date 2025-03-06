<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'task_id' => 1,
            'account_type_id' => 1,
            // 'group_id' => 1,
            'nama' => 'Helmi',
            'npwp' => '35730116969',
            'alamat_utama' => 'Jln. ALamat Helmi',
            'email' => 'helmi@example.com',
        ]);

        Account::create([
            'task_id' => 1,
            'account_type_id' => 2,
            // 'group_id' => 1,
            'nama' => 'Badan 1',
            'npwp' => '35730117070',
            'alamat_utama' => 'Jln. Badan 1',
            'email' => 'badan1@example.com',
        ]);

        Account::create([
            'task_id' => 1,
            'account_type_id' => 3,
            // 'group_id' => 1,
            'nama' => 'Helmi Lawan Transaksi',
            'npwp' => '35730118080',
            'alamat_utama' => 'Jln. ALamat Helmi Transaksi',
            'email' => 'helmiLawan@example.com',
        ]);

        Account::create([
            'task_id' => 2,
            'account_type_id' => 1,
            // 'group_id' => 1,
            'nama' => 'Bani',
            'npwp' => '35730116969111',
            'alamat_utama' => 'Jln. ALamat Bani',
            'email' => 'bani@example.com',
        ]);

        Account::create([
            'task_id' => 2,
            'account_type_id' => 2,
            // 'group_id' => 1,
            'nama' => 'Badan 2',
            'npwp' => '35730117070111',
            'alamat_utama' => 'Jln. ALamat Badan 2',
            'email' => 'badan2@example.com',
        ]);

        Account::create([
            'task_id' => 2,
            'account_type_id' => 3,
            // 'group_id' => 1,
            'nama' => 'Bani Lawan Transaksi',
            'npwp' => '35730118080111',
            'alamat_utama' => 'Jln. ALamat Bani Transaksi',
            'email' => 'baniLawan@example.com',
        ]);

        Account::create([
            'task_id' => 2,
            'account_type_id' => 4,
            // 'group_id' => 1,
            'nama' => 'Badan Lawan Transaksi',
            'npwp' => '35730118080111',
            'alamat_utama' => 'Jln. ALamat Badan Transaksi',
            'email' => 'badanLawan@example.com',
        ]);
    }
}