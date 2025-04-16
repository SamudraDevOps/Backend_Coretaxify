<?php

namespace Tests\Feature\Http\Controllers\Helpers;

use App\Models\Role;
use App\Models\User;
use App\Models\Contract;

class Dummy {

    public function createAdmin(): User {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory(['name' => 'Super Admin'])->create();
        $admin->roles()->attach($role);

        return $admin;
    }
    public function createDosen(): User {
        $role = Role::firstOrCreate(['name' => 'dosen']);
        $dosen = User::factory(['name' => 'Dosen'])->create();
        $dosen->roles()->attach($role);

        return $dosen;
    }
    public function createMahasiswa(): User {
        $role = Role::firstOrCreate(['name' => 'mahasiswa']);
        $mahasiswa = User::factory(['name' => 'Mahasiswa'])->create();
        $mahasiswa->roles()->attach($role);

        return $mahasiswa;
    }

    public function createPsc(): User {
        $role = Role::firstOrCreate(['name' => 'psc']);
        $psc = User::factory(['name' => 'Psc'])->create();
        $psc->roles()->attach($role);

        return $psc;
    }

    public function createMahasiswaPsc(): User {
        $role = Role::firstOrCreate(['name' => 'mahasiswa-psc']);
        $mahasiswaPsc = User::factory(['name' => 'MahasiswaPsc'])->create();
        $mahasiswaPsc->roles()->attach($role);

        return $mahasiswaPsc;
    }

    public function createInstruktur(): User {
        $role = Role::firstOrCreate(['name' => 'instruktur']);
        $instruktur = User::factory(['name' => 'Instruktur'])->create();
        $instruktur->roles()->attach($role);

        return $instruktur;
    }

    public function createContract(): Contract {
        $contract = Contract::factory()->create();

        return $contract;
    }

}
