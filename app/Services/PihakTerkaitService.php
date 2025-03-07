<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\PihakTerkait;
use Illuminate\Support\Str;
use App\Support\Interfaces\Repositories\PihakTerkaitRepositoryInterface;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;

class PihakTerkaitService extends BaseCrudService implements PihakTerkaitServiceInterface {
    protected function getRepositoryClass(): string {
        return PihakTerkaitRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $randomNumber = 'DA' . mt_rand(10000000, 99999999);
        
        $pihakTerkait = PihakTerkait::create([
            'nama_pengurus' => $data['nama_pengurus'],
            'npwp' => $data['npwp'],
            'id_penunjukkan_perwakilan' => $randomNumber, 
        ]);
        
        return $pihakTerkait;
    }
}