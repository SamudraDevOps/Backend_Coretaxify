<?php

namespace App\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\InformasiUmum;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\InformasiUmumServiceInterface;
use App\Support\Interfaces\Repositories\InformasiUmumRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class InformasiUmumService extends BaseCrudService implements InformasiUmumServiceInterface {
    protected function getRepositoryClass(): string {
        return InformasiUmumRepositoryInterface::class;
    }
}
