<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exam = Exam::create([
            'user_id' => 2,
            'task_id' => 1,
            'name' => 'ujian dosen',
            'exam_code' => 'ujiandosen',
            'start_period' => now(),
            'end_period' => now()->addYears(1),
            'duration' => 40,
        ]);

        $exampsc = Exam::create([
            'user_id' => 5,
            'task_id' => 2,
            'name' => 'ujian psc',
            'exam_code' => 'ujianpsc',
            'start_period' => now(),
            'end_period' => now()->addYears(1),
            'duration' => 30,
        ]);
    }
}
