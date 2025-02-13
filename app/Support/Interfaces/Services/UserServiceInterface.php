<?php

namespace App\Support\Interfaces\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface UserServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data): ?Model;
    public function assignRoleByIntent(User $user, ?string $intent): void;
    public function importData(array $data): void;
}
