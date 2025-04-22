<?php

namespace App\Support\Interfaces\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\DetailTransaksi;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface DetailTransaksiServiceInterface extends BaseCrudServiceInterface {
    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Faktur $faktur): void;

    public function authorizeDetailTraBelongsToFaktur(Faktur $faktur, DetailTransaksi $detailTransaksi): void;
}
