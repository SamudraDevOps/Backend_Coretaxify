<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotRepositoryInterface;
use App\Support\Interfaces\Services\BupotServiceInterface;
use Illuminate\Database\Eloquent\Model;

class BupotService extends BaseCrudService implements BupotServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotRepositoryInterface::class;
    }
    
    public function create(array $data): ?Model {
        $data['nomor_pemotongan'] = $this->generateNomorPemotongan();

        return parent::create($data);
    }

    private function generateNomorPemotongan() {
        $string1 = rand(0000, 9999);
        $string2 = strtoupper(str()->random(5));

        return $string1 . $string2;
    }
}
