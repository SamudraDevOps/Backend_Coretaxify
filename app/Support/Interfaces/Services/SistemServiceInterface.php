<?php

namespace App\Support\Interfaces\Services;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assignment;
use App\Models\Sistem;
use Illuminate\Http\Request;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface SistemServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data): ?Model;

    public function getSystemsByAssignment(Assignment $assignment, Request $request);

    public function getSystemDetail(Assignment $assignment, Sistem $sistem, Request $request, string $intent = null);

    public function getFirstSystemByAssignment(Assignment $assignment);
}
