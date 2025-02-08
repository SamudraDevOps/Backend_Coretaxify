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

        $psc = User::create([
            'name' => 'PSC',
            'email' => 'psc@email.com',
            'password' => Hash::make('password123'),
        ]);
        $psc->roles()->attach(Role::where('name', 'psc')->first());

        $instructor1 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor1@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor1->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor2 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor2@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor2->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor3 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor3@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor3->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor4 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor4@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor4->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor5 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor5@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor5->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor6 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor6@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor6->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor7 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor7@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor7->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor8 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor8@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor8->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor9 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor9@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor9->roles()->attach(Role::where('name', 'instruktur')->first());

        $instructor10 = User::create([
            'name' => 'Instructor',
            'email' => 'instructor10@email.com',
            'password' => Hash::make('password123'),
        ]);
        $instructor10->roles()->attach(Role::where('name', 'instruktur')->first());
    }
}
