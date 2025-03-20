<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\UnitPajakKeluargaRepositoryInterface;
use App\Support\Interfaces\Services\UnitPajakKeluargaServiceInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistem;

class UnitPajakKeluargaService extends BaseCrudService implements UnitPajakKeluargaServiceInterface {
    protected function getRepositoryClass(): string {
        return UnitPajakKeluargaRepositoryInterface::class;
    }

    public function create(array $data, ?Sistem $sistem = null): ?Model {
        return $this->repository->create([
            'nik_anggota_keluarga' => $data['nik_anggota_keluarga'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tempat_lahir' => $data['tempat_lahir'],
            'nomor_kartu_keluarga' => $data['nomor_kartu_keluarga'],
            'nama_anggota_keluarga' => $data['nama_anggota_keluarga'],
            'status_hubungan_keluarga' => $data['status_hubungan_keluarga'],
            'pekerjaan' => $data['pekerjaan'],
            'status_unit_perpajakan' => $data['status_unit_perpajakan'],
            'status_ptkp' => $data['status_ptkp'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'sistem_id' => $sistem->id,
        ]);
    }
}
