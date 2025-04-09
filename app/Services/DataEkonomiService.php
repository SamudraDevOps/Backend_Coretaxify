<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\DataEkonomi;
use App\Models\Sistem;
use App\Support\Interfaces\Repositories\DataEkonomiRepositoryInterface;
use App\Support\Interfaces\Services\DataEkonomiServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataEkonomiService extends BaseCrudService implements DataEkonomiServiceInterface {
    protected function getRepositoryClass(): string {
        return DataEkonomiRepositoryInterface::class;
    }

    /**
     * Get repository instance
     *
     * @return DataEkonomiRepositoryInterface
     */
    protected function getRepository(): DataEkonomiRepositoryInterface
    {
        return app($this->getRepositoryClass());
    }

    /**
     * Get DataEkonomi by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getRepository()->getById($id);
    }

    /**
     * Get DataEkonomi by merek dagang
     *
     * @param string $merekDagang
     * @return Collection
     */
    public function getByMerekDagang(string $merekDagang): Collection
    {
        return $this->getRepository()->getByMerekDagang($merekDagang);
    }

    /**
     * Get DataEkonomi by omset range
     *
     * @param float $minOmset
     * @param float $maxOmset
     * @return Collection
     */
    public function getByOmsetRange(float $minOmset, float $maxOmset): Collection
    {
        return $this->getRepository()->getByOmsetRange($minOmset, $maxOmset);
    }

    /**
     * Get DataEkonomi by employee status
     *
     * @param bool $isKaryawan
     * @return Collection
     */
    public function getByEmployeeStatus(bool $isKaryawan): Collection
    {
        return $this->getRepository()->getByEmployeeStatus($isKaryawan);
    }

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
    ): ?Model
    {
        $this->authorizeAccess($assignment, $sistem, $dataEkonomi);

        return $dataEkonomi;
    }

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
    ): ?Model
    {
        $this->authorizeAccess($assignment, $sistem, $dataEkonomi);

        return $this->update($dataEkonomi, $data);
    }

    /**
     * Authorize access to the sistem and data ekonomi
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DataEkonomi $dataEkonomi
     * @return void
     */
    private function authorizeAccess(Assignment $assignment, Sistem $sistem, DataEkonomi $dataEkonomi): void
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => Auth::id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403, 'Unauthorized access to this sistem');
        }

        // Verify the sistem exists for this assignment user
        Sistem::where('assignment_user_id', $assignmentUser->id)
            ->where('id', $sistem->id)
            ->firstOrFail();

        // Additional check to ensure the data ekonomi belongs to the correct sistem
        // This assumes there's a relationship between sistem and data ekonomi through portal_saya and profil_saya
        if ($dataEkonomi->id !== $sistem->profil_saya->data_ekonomi_id) {
            abort(403, 'Unauthorized access to this data ekonomi');
        }
    }
}
