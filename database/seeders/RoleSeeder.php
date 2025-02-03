<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'Admin',
        ]);

        Role::create([
            'name' => 'Dosen',
        ]);

        Role::create([
            'name' => 'Mahasiswa',
        ]);
    }
}