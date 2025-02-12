<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        AccountType::create([
            'name' => 'Orang Pribadi',
        ]);

        AccountType::create([
            'name' => 'Badan',
        ]);

        AccountType::create([
            'name' => 'Orang Pribadi Lawan Transaksi',
        ]);

        AccountType::create([
            'name' => 'Badan Lawan Transaksi',
        ]);
    }
}
