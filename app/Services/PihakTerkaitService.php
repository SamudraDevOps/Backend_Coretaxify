<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\PihakTerkait;
use App\Models\WakilSaya;
use Illuminate\Support\Str;
use App\Support\Interfaces\Repositories\PihakTerkaitRepositoryInterface;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;

class PihakTerkaitService extends BaseCrudService implements PihakTerkaitServiceInterface {
    protected function getRepositoryClass(): string {
        return PihakTerkaitRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $pihakTerkait = PihakTerkait::create($data);
        
        $randomNumber = 'DA' . Str::random(8);
                
    WakilSaya::create([
           'nama' => $pihakTerkait->nama,
           'npwp' => $pihakTerkait->npwp,
           'id_penunjukkan_perwakilan' => $randomNumber,
        ]);
        
        return $pihakTerkait;
    }
}