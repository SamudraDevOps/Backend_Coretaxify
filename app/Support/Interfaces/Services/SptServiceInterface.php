<?php

namespace App\Support\Interfaces\Services;

use App\Models\Sistem;
use App\Models\Spt;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface SptServiceInterface extends BaseCrudServiceInterface {
    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Request $request):void;

    public function checkPeriode(Assignment $assignment, Sistem $sistem, Request $request);

    public function create(array $data): Model;

    public function update($spt, $request): Model;

    public function getAllForSpt(Sistem $sistem, int $perPage, array $filters = []);

    public function showDetailSpt(Spt $spt);

    public function calculateSpt(Spt $spt, Request $request);

    public function showFakturSptPpn($spt, Request $request);

    public function showBupotSptPph($spt, Request $request);

    public function showBupotSptPphUnifikasi($spt, Request $request);
}
