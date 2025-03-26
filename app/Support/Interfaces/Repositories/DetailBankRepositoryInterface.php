<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DetailBankRepositoryInterface extends BaseRepositoryInterface {
    /**
     * Get DetailBank by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Get DetailBank by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection;

    /**
     * Get DetailBank by nama bank
     *
     * @param string $namaBank
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNamaBank(string $namaBank, ?int $sistemId = null): Collection;

    /**
     * Get DetailBank by nomor rekening
     *
     * @param string $nomorRekening
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNomorRekening(string $nomorRekening, ?int $sistemId = null): Collection;

    /**
     * Get DetailBank by jenis rekening
     *
     * @param string $jenisRekening
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisRekening(string $jenisRekening, ?int $sistemId = null): Collection;
}
