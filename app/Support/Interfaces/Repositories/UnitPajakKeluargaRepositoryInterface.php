<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use App\Models\UnitPajakKeluarga;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface UnitPajakKeluargaRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get UnitPajakKeluarga by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Get UnitPajakKeluarga by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection;

    /**
     * Get UnitPajakKeluarga by NIK
     *
     * @param string $nik
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNik(string $nik, ?int $sistemId = null): Collection;

    /**
     * Get UnitPajakKeluarga by nama anggota keluarga
     *
     * @param string $nama
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNama(string $nama, ?int $sistemId = null): Collection;

    /**
     * Get UnitPajakKeluarga by status hubungan keluarga
     *
     * @param string $statusHubungan
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByStatusHubungan(string $statusHubungan, ?int $sistemId = null): Collection;

    /**
     * Get UnitPajakKeluarga by nomor kartu keluarga
     *
     * @param string $nomorKK
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNomorKK(string $nomorKK, ?int $sistemId = null): Collection;
}
