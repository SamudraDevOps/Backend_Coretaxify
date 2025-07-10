<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use App\Models\Assignment;
use App\Models\DetailKontak;
use App\Models\Sistem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface DetailKontakServiceInterface extends BaseCrudServiceInterface {
    /**
     * Create a new DetailKontak
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model;

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

    /**
     * Get all DetailKontak for a Sistem with pagination
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
     * Get DetailKontak detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return Model|null
     */
    public function getDetailKontakDetail(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        Request $request
    ): ?Model;

    /**
     * Update DetailKontak with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @param array $data
     * @return Model|null
     */
    public function updateDetailKontak(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        array $data,
        Request $request
    ): ?Model;

    /**
     * Delete DetailKontak with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return bool
     */
    public function deleteDetailKontak(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        Request $request
    ): bool;
}
