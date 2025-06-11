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
                'start_period' => now(),
                'end_period' => now()->addYears(1),
                'class_code' => 'ABCD',
                'status' => 'ACTIVE',
            ]);
        $groups->users()->attach([3,4]);

        $groups2 = Group::create([
                'name' => 'Kelas PSC',
                'user_id' => 5,
                'start_period' => now(),
                'end_period' => now()->addYears(1),
                'class_code' => 'DCBA',
                'status' => 'ACTIVE',
            ]);
        $groups2->users()->attach(16);
    }
}
