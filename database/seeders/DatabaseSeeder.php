<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UniversitySeeder::class,
            AccountTypeSeeder::class,
            ContractSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            TaskSeeder::class,
            GroupSeeder::class,
            AccountSeeder::class,
            ExamSeeder::class,
            AssignmentSeeder::class,
            KodeTransaksiSeeder::class,
            SatuanSeeder::class,
            KapKjsSeeder::class,
            InformasiTambahanSeeder::class,
            BupotObjekPajakSeeder::class,
            SistemSeeder::class,
            BupotSeeder::class,
            PicSeeder::class,
            // FakturSeeder::class,
        ]);
    }
}
