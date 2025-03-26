<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use App\Models\DataEkonomi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataEkonomiRepositoryInterface extends BaseRepositoryInterface {
    /**
     * Get DataEkonomi by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Get DataEkonomi by merek dagang
     *
     * @param string $merekDagang
     * @return Collection
     */
    public function getByMerekDagang(string $merekDagang): Collection;

    /**
     * Get DataEkonomi by omset range
     *
     * @param float $minOmset
     * @param float $maxOmset
     * @return Collection
     */
    public function getByOmsetRange(float $minOmset, float $maxOmset): Collection;

    /**
     * Get DataEkonomi by employee status
     *
     * @param bool $isKaryawan
     * @return Collection
     */
    public function getByEmployeeStatus(bool $isKaryawan): Collection;
}
