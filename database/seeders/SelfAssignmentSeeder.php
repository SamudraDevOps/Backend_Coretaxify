<?php

namespace Database\Seeders;

use App\Models\SelfAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SelfAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SelfAssignment::create([
            'user_id' => 2,
            'task_id' => 1,
            'name' => 'Self Assignment 1',
        ]);
    }
}
