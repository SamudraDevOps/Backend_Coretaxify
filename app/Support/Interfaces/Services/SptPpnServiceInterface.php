<?php

namespace App\Support\Interfaces\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface SptPpnServiceInterface extends BaseCrudServiceInterface {

    public function create(array $data): Model;

    public function authorizeAccess(Assignment $assignment, Sistem $sistem);
}
