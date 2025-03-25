<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use App\Models\TempatKegiatanUsaha;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TempatKegiatanUsahaRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get TempatKegiatanUsaha by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Get TempatKegiatanUsaha by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection;

    /**
     * Get TempatKegiatanUsaha by NITKU
     *
     * @param string $nitku
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNitku(string $nitku, ?int $sistemId = null): Collection;

    /**
     * Get TempatKegiatanUsaha by jenis TKU
     *
     * @param string $jenisTku
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisTku(string $jenisTku, ?int $sistemId = null): Collection;

    /**
     * Get TempatKegiatanUsaha by nama TKU
     *
     * @param string $namaTku
     * @param int|null $sistemId
     * @return Collection
     */
    // public function getByNamaTku(string $namaTku, ?int $sistemId = null): Collection;
}
