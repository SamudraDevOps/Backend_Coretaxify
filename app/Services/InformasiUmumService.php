<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\InformasiUmum;
use App\Models\Sistem;
use App\Support\Enums\IntentEnum;
use App\Support\Interfaces\Repositories\InformasiUmumRepositoryInterface;
use App\Support\Interfaces\Services\InformasiUmumServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiUmumService extends BaseCrudService implements InformasiUmumServiceInterface {
    protected function getRepositoryClass(): string {
        return InformasiUmumRepositoryInterface::class;
    }

    /**
     * Get repository instance
     *
     * @return InformasiUmumRepositoryInterface
     */
    protected function getRepository(): InformasiUmumRepositoryInterface
    {
        return app($this->getRepositoryClass());
    }

    /**
     * Get InformasiUmum by ID with validation
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getRepository()->getById($id);
    }

    /**
     * Get InformasiUmum by NPWP
     *
     * @param string $npwp
     * @return Model|null
     */
    public function getByNpwp(string $npwp): ?Model
    {
        return $this->getRepository()->getByNpwp($npwp);
    }

    /**
     * Get InformasiUmum by name
     *
     * @param string $name
     * @return Collection
     */
    public function getByName(string $name): Collection
    {
        return $this->getRepository()->getByName($name);
    }

    /**
     * Get InformasiUmum by jenis wajib pajak
     *
     * @param string $jenisWajibPajak
     * @return Collection
     */
    public function getByJenisWajibPajak(string $jenisWajibPajak): Collection
    {
        return $this->getRepository()->getByJenisWajibPajak($jenisWajibPajak);
    }

    /**
     * Get InformasiUmum detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param InformasiUmum $informasiUmum
     * @param Request $request
     * @return Model|null
     */
    public function getInformasiUmumDetail(
        Assignment $assignment,
        Sistem $sistem,
        InformasiUmum $informasiUmum,
        Request $request
    ): ?Model
    {
        $this->authorizeAccess($assignment, $sistem);

        return $informasiUmum;
    }

    /**
     * Update InformasiUmum with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param InformasiUmum $informasiUmum
     * @param array $data
     * @return Model|null
     */
    public function updateInformasiUmum(
        Assignment $assignment,
        Sistem $sistem,
        InformasiUmum $informasiUmum,
        array $data
    ): ?Model
    {
        $this->authorizeAccess($assignment, $sistem);

        return $this->update($informasiUmum, $data);
    }

    /**
     * Authorize access to the sistem
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @return void
     */
    private function authorizeAccess(Assignment $assignment, Sistem $sistem): void
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
    }
}
