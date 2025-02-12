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
        Task::create([
            'name' => 'Soal 1',
            // 'file_path' => 'Buku1.pdf',
        ]);

        Task::create([
            'name' => 'Soal 2',
            // 'file_path' => 'Buku2.pdf',
        ]);
    }
}
