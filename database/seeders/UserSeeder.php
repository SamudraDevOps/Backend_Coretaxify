<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        // $admin->assignRole('admin');

        $dosen = User::create([
            'name' => 'Dosen User',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password123'),
        ]);
        $dosen->roles()->attach(Role::where('name', 'dosen')->first());

        $mhs1 = User::create([
            'name' => 'Mahasiswa 1 User',
            'email' => 'mahasiswa1@example.com',
            'password' => Hash::make('password123'),
        ]);
        $mhs1->roles()->attach(Role::where('name', 'mahasiswa')->first());

        $mhs2 = User::create([
            'name' => 'Mahasiswa 2 User',
            'email' => 'mahasiswa2@example.com',
            'password' => Hash::make('password123'),
        ]);
        $mhs2->roles()->attach(Role::where('name', 'mahasiswa')->first());

    }
}