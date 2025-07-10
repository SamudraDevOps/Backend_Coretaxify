<?php

namespace App\Support\Interfaces\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface DetailTransaksiServiceInterface extends BaseCrudServiceInterface {
    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Faktur $faktur, Request $request): void;

    public function authorizeDetailTraBelongsToFaktur(Faktur $faktur, DetailTransaksi $detailTransaksi, Request $request): void;
}
