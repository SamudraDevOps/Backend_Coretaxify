<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use App\Models\DetailKontak;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DetailKontakRepositoryInterface extends BaseRepositoryInterface {
    /**
     * Get DetailKontak by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Get DetailKontak by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection;

    /**
     * Get DetailKontak by jenis kontak
     *
     * @param string $jenisKontak
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisKontak(string $jenisKontak, ?int $sistemId = null): Collection;

    /**
     * Get DetailKontak by email
     *
     * @param string $email
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByEmail(string $email, ?int $sistemId = null): Collection;

    /**
     * Get DetailKontak by phone number
     *
     * @param string $phoneNumber
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByPhoneNumber(string $phoneNumber, ?int $sistemId = null): Collection;
}