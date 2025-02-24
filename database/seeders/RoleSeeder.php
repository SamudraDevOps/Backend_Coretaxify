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
    public function run(): void {
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator',
        ]);

        Role::create([
            'name' => 'dosen',
            'description' => 'Lecturer',
        ]);

        Role::create([
            'name' => 'mahasiswa',
            'description' => 'Student',
        ]);

        Role::create([
            'name' => 'psc',
            'description' => 'PSC',
        ]);
        Role::create([
            'name' => 'mahasiswa-psc',
            'description' => 'Student-PSC',
        ]);

        Role::create([
            'name' => 'instruktur',
            'description' => 'Instructor',
        ]);
    }
}
