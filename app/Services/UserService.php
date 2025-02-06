<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\UserServiceInterface;
use App\Support\Interfaces\Repositories\UserRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class UserService extends BaseCrudService implements UserServiceInterface {
    protected function getRepositoryClass(): string {
        return UserRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $plain_password = Str::random(8);
        $data['default_password'] = $plain_password;
        $data['password'] = $plain_password;

        $user = parent::create($data);
        // $user->assignRole('dosen');
        $user->roles()->attach(Role::where('name', 'admin')->first());
        return $user;
    }
}
