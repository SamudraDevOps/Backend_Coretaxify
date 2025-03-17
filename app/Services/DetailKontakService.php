<?php

namespace App\Services;

use App\Models\Sistem;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\DetailKontakServiceInterface;
use App\Support\Interfaces\Repositories\DetailKontakRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class DetailKontakService extends BaseCrudService implements DetailKontakServiceInterface {
    protected function getRepositoryClass(): string {
        return DetailKontakRepositoryInterface::class;
    }

    public function create(array $data, ?Sistem $sistem = null): ?Model{
        return $this->repository->create([
            'jenis_kontak' => $data['jenis_kontak'],
            'nomor_telpon' => $data['nomor_telpon'],
            'nomor_handphone' => $data['nomor_handphone'],
            'nomor_faksimile' => $data['nomor_faksimile'],
            'alamat_email' => $data['alamat_email'],
            'alamat_situs_wajib' => $data['alamat_situs_wajib'],
            'keterangan' => $data['keterangan'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'sistem_id' => $sistem->id,
        ]);
    }
}
