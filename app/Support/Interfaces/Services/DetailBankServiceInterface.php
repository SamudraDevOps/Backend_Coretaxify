<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use App\Models\Assignment;
use App\Models\DetailBank;
use App\Models\Sistem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface DetailBankServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data, ?Sistem $sistem = null): ?Model;

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

    /**
     * Get all DetailBank for a Sistem with pagination
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
     * Get DetailBank detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return Model|null
     */
    public function getDetailBankDetail(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank
    ): ?Model;

    /**
     * Update DetailBank with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @param array $data
     * @return Model|null
     */
    public function updateDetailBank(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank,
        array $data
    ): ?Model;

    /**
     * Delete DetailBank with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return bool
     */
    public function deleteDetailBank(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank
    ): bool;
}
