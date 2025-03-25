<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use App\Models\Assignment;
use App\Models\Sistem;
use App\Models\TempatKegiatanUsaha;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface TempatKegiatanUsahaServiceInterface extends BaseCrudServiceInterface
{
    /**
     * Create a new TempatKegiatanUsaha
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model;

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

    // /**
    //  * Get TempatKegiatanUsaha by nama TKU
    //  *
    //  * @param string $namaTku
    //  * @param int|null $sistemId
    //  * @return Collection
    //  */
    // public function getByNamaTku(string $namaTku, ?int $sistemId = null): Collection;

    /**
     * Get all TempatKegiatanUsaha for a Sistem with pagination
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @param int $perPage
     * @return mixed
     */
    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    );

    /**
     * Get TempatKegiatanUsaha detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @return Model|null
     */
    public function getTempatKegiatanUsahaDetail(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha
    ): ?Model;

    /**
     * Update TempatKegiatanUsaha with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @param array $data
     * @return Model|null
     */
    public function updateTempatKegiatanUsaha(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha,
        array $data
    ): ?Model;

    /**
     * Delete TempatKegiatanUsaha with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @return bool
     */
    public function deleteTempatKegiatanUsaha(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha
    ): bool;
}
