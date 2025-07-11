<?php

namespace App\Support\Interfaces\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface SistemTambahanServiceInterface extends BaseCrudServiceInterface {
    // public function create(array $data, Sistem $sistem = null): ?Model;

    public function authorizeAccess(Assignment $assignment, Sistem $sistem): void;

    public function authorizeFakturBelongsToSistem(Faktur $faktur, Sistem $sistem): void;
}