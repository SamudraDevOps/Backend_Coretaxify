<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Support\Enums\IntentEnum;
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
        $this->assignRoleByIntent($user, $data['intent'] ?? null);
        return $user;
    }

    public function assignRoleByIntent(Model $user, ?string $intent): void {
        if (!$user instanceof User) {
            return;
        }

        switch($intent) {
            case IntentEnum::API_USER_CREATE_INSTRUCTOR->value:
                $user->roles()->attach(Role::where('name', 'instruktur')->first());
                break;
            default:
                $user->roles()->attach(Role::where('name', 'dosen')->first());
        }
    }
}
