<?php

namespace App\Support\Interfaces\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\PihakTerkait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface PihakTerkaitServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data , ?Sistem $sistem = null  ): ?Model;

    public function getAllBySistemId(array $filters, int $sistemId): Collection;

    /**
     * Get all PihakTerkait for a Sistem with pagination
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
     * Get PihakTerkait detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @return Model|null
     */
    public function getPihakTerkaitDetail(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait
    ): ?Model;

    /**
     * Update PihakTerkait with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @param array $data
     * @return Model|null
     */
    public function updatePihakTerkait(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait,
        array $data
    ): ?Model;

    /**
     * Delete PihakTerkait with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @return bool
     */
    public function deletePihakTerkait(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait
    ): bool;
}
