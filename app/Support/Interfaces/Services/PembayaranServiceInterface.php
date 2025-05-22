<?php

namespace App\Support\Interfaces\Services;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\Pembayaran;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface PembayaranServiceInterface extends BaseCrudServiceInterface {
    public function authorizeAccess(Assignment $assignment, Sistem $sistem):void;

    public function getAllForPembayaran(Sistem $sistem, int $perPage);
}
