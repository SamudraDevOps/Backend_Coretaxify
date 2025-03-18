<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\TempatKegiatanUsahaRepositoryInterface;
use App\Support\Interfaces\Services\TempatKegiatanUsahaServiceInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistem;

class TempatKegiatanUsahaService extends BaseCrudService implements TempatKegiatanUsahaServiceInterface {
    protected function getRepositoryClass(): string {
        return TempatKegiatanUsahaRepositoryInterface::class;
    }

    public function create(array $data, ?Sistem $sistem = null): ?Model{
        return $this->repository->create([
            'nitku' => $data['nitku'],
            'jenis_tku' => $data['jenis_tku'],
            'nama_tku' => $data['nama_tku'],
            'jenis_usaha' => $data['jenis_usaha'],
            'sistem_id' => $sistem->id,
        ]);
    }
}
