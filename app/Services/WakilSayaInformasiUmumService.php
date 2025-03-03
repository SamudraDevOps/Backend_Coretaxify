<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\WakilSayaInformasiUmumRepositoryInterface;
use App\Support\Interfaces\Services\WakilSayaInformasiUmumServiceInterface;
use Illuminate\Database\Eloquent\Model;

class WakilSayaInformasiUmumService extends BaseCrudService implements WakilSayaInformasiUmumServiceInterface {
    protected function getRepositoryClass(): string {
        return WakilSayaInformasiUmumRepositoryInterface::class;
    }
    }