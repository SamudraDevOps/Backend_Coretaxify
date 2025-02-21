<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task1 = Task::create([
            'user_id' => 1,
            'name' => 'Soal 1',
            // 'file_path' => 'Buku1.pdf',
        ]);
        $task1->contracts()->attach([1]);

        $task2 = Task::create([
            'user_id' => 1,
            'name' => 'Soal 2',
            // 'file_path' => 'Buku2.pdf',
        ]);
        $task2->contracts()->attach([1]);
    }
}
