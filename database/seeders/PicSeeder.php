<?php

namespace Database\Seeders;

use App\Models\Pic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pic::create([
            'akun_op_id' => '1',
            'akun_badan_id' => '2',
            'assignment_user_id' => '1',
        ]);

        Pic::create([
            'akun_op_id' => '3',
            'akun_badan_id' => '1',
            'assignment_user_id' => '1',
        ]);
    }
}
