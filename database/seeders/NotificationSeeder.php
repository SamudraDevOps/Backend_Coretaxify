<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::create([
            'sistem_id' => 2,
            'pengirim' => 'pengirim seeder 1',
            'subjek' => 'subjek seeder 1',
            'isi' => 'isi seeder 1',
        ]);

        Notification::create([
            'sistem_id' => 2,
            'pengirim' => 'pengirim seeder 2',
            'subjek' => 'subjek seeder 2',
            'isi' => 'isi seeder 2',
        ]);

        Notification::create([
            'sistem_id' => 2,
            'pengirim' => 'pengirim seeder 3',
            'subjek' => 'subjek seeder 3',
            'isi' => 'isi seeder 3',
        ]);
    }
}
