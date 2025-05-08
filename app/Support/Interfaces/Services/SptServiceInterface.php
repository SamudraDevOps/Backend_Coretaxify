<?php

namespace App\Support\Interfaces\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface SptServiceInterface extends BaseCrudServiceInterface {
    public function authorizeAccess(Assignment $assignment, Sistem $sistem):void;

    public function checkPeriode(Assignment $assignment, Sistem $sistem, Request $request);

    public function create(array $data): Model;
}
