<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignment = Assignment::create([
            'user_id' => 2,
            'task_id' => 1,
            'name' => 'tugas dosen',
            'assignment_code' => 'tugasdosen',
            'start_period' => '2024-02-02',
            'end_period' => '2024-02-03',
        ]);
        $assignment->groups()->attach(1);
        $assignment->users()->attach([3,4]);

        $assignment2 = Assignment::create([
            'user_id' => 3,
            'task_id' => 2,
            'name' => 'tugas psc',
            'assignment_code' => 'tugaspsc',
            'start_period' => '2024-02-02',
            'end_period' => '2024-02-03',
        ]);
        $assignment2->groups()->attach(1);
        $assignment2->users()->attach([3,4]);
    }
}
