<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use App\Models\Assignment;
use App\Models\Sistem;
use App\Models\UnitPajakKeluarga;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface UnitPajakKeluargaServiceInterface extends BaseCrudServiceInterface
{
    /**
     * Create a new UnitPajakKeluarga
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model;

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

    /**
     * Get all UnitPajakKeluarga for a Sistem with pagination
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
     * Get UnitPajakKeluarga detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @return Model|null
     */
    public function getUnitPajakKeluargaDetail(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga
    ): ?Model;

    /**
     * Update UnitPajakKeluarga with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @param array $data
     * @return Model|null
     */
    public function updateUnitPajakKeluarga(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga,
        array $data
    ): ?Model;

    /**
     * Delete UnitPajakKeluarga with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @return bool
     */
    public function deleteUnitPajakKeluarga(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga
    ): bool;
}
