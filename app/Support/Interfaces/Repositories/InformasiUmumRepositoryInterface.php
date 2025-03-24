<?php

namespace App\Support\Interfaces\Repositories;
use App\Models\InformasiUmum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;

interface InformasiUmumRepositoryInterface extends BaseRepositoryInterface {
    /**
     * Get InformasiUmum by ID
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
}
