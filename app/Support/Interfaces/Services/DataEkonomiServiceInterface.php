<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use App\Models\Assignment;
use App\Models\DataEkonomi;
use App\Models\Sistem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
interface DataEkonomiServiceInterface extends BaseCrudServiceInterface {
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

    /**
     * Get DataEkonomi detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DataEkonomi $dataEkonomi
     * @param Request $request
     * @return Model|null
     */
    public function getDataEkonomiDetail(
        Assignment $assignment,
        Sistem $sistem,
        DataEkonomi $dataEkonomi,
        Request $request
    ): ?Model;

    /**
     * Update DataEkonomi with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DataEkonomi $dataEkonomi
     * @param array $data
     * @return Model|null
     */
    public function updateDataEkonomi(
        Assignment $assignment,
        Sistem $sistem,
        DataEkonomi $dataEkonomi,
        array $data
    ): ?Model;
}
