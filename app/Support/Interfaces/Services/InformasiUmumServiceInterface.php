<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use App\Models\Assignment;
use App\Models\InformasiUmum;
use App\Models\Sistem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface InformasiUmumServiceInterface extends BaseCrudServiceInterface {
    /**
     * Get InformasiUmum by ID with validation
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * Get InformasiUmum by NPWP
     *
     * @param string $npwp
     * @return Model|null
     */
    public function getByNpwp(string $npwp): ?Model;

    /**
     * Get InformasiUmum by name
     *
     * @param string $name
     * @return Collection
     */
    public function getByName(string $name): Collection;

    /**
     * Get InformasiUmum by jenis wajib pajak
     *
     * @param string $jenisWajibPajak
     * @return Collection
     */
    public function getByJenisWajibPajak(string $jenisWajibPajak): Collection;

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
    ): ?Model;

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
    ): ?Model;
}
