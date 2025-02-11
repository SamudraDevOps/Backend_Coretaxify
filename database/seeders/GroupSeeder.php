<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Group::create([
                'name' => 'Kelas 1A',
                'user_id' => 2,
                'qty_student' => 50,
                'start_period' => now(),
                'end_period' => now()->addYears(1),
                'spt' => 5,
                'bupot' => 5,
                'faktur' => 5,
                'class_code' => 'ABCD',
                'status' => 'ACTIVE',   
            ]);
    }
}