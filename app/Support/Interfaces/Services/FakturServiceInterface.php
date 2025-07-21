<?php

namespace App\Support\Interfaces\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface FakturServiceInterface extends BaseCrudServiceInterface {

    public function create(array $data , ?Sistem $sistem = null  ): ?Model;

    public function authorizeFakturBelongsToSistem(Faktur $faktur, Sistem $sistem, Request $request);

    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Request $request);

    public function update($keyOrModel, array $data): ?Model;

    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    );

    public function getDashboardData(Assignment $assignment, Sistem $sistem);

}
