<?php

// use App\Support\Enums\RoleEnum;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Pest\PendingCalls\TestCall;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
// use App\Models\Permission;
// use App\Support\Enums\PermissionEnum;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, DatabaseTransactions::class)->in('Feature');
// uses(TestCase::class)->in('Feature');

// Allow File facade to be loaded
uses(TestCase::class)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function actAsAdmin(): TestCall|TestCase {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory(['name' => 'Super Admin'])->create();
    $admin->roles()->attach($role);

    return test()->actingAs($admin);
}
function actAsDosen(): TestCall|TestCase {
    $role = Role::firstOrCreate(['name' => 'dosen']);
    $dosen = User::factory(['name' => 'Dosen'])->create();
    $dosen->roles()->attach($role);

    return test()->actingAs($dosen);
}
function actAsMahasiswa(): TestCall|TestCase {
    $role = Role::firstOrCreate(['name' => 'mahasiswa']);
    $mahasiswa = User::factory(['name' => 'Mahasiswa'])->create();
    $mahasiswa->roles()->attach($role);

    return test()->actingAs($mahasiswa);
}

function actAsPsc(): TestCall|TestCase {
    $role = Role::firstOrCreate(['name' => 'psc']);
    $psc = User::factory(['name' => 'Psc'])->create();
    $psc->roles()->attach($role);

    return test()->actingAs($psc);
}

function actAsMahasiswaPsc(): TestCall|TestCase {
    $role = Role::firstOrCreate(['name' => 'mahasiswa-psc']);
    $mahasiswaPsc = User::factory(['name' => 'MahasiswaPsc'])->create();
    $mahasiswaPsc->roles()->attach($role);

    return test()->actingAs($mahasiswaPsc);
}

function actAsInstruktur(): TestCall|TestCase {
    $role = Role::firstOrCreate(['name' => 'instruktur']);
    $instruktur = User::factory(['name' => 'Instruktur'])->create();
    $instruktur->roles()->attach($role);

    return test()->actingAs($instruktur);
}
