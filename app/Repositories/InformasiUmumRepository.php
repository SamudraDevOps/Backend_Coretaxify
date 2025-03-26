<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\InformasiUmum;
use App\Support\Interfaces\Repositories\InformasiUmumRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InformasiUmumRepository extends BaseRepository implements InformasiUmumRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return InformasiUmum::class;
    }

    protected function applyFilters(array $searchParams = []): Builder {
        $query = $this->getQuery();

        $query = $this->applySearchFilters($query, $searchParams, ['name']);

        $query = $this->applyColumnFilters($query, $searchParams, ['id']);

        $query = $this->applyResolvedRelations($query, $searchParams);

        $query = $this->applySorting($query, $searchParams);

        return $query;
    }

    /**
     * Get InformasiUmum by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * Get InformasiUmum by NPWP
     *
     * @param string $npwp
     * @return Model|null
     */
    public function getByNpwp(string $npwp): ?Model
    {
        return $this->getQuery()->where('npwp', $npwp)->first();
    }

    /**
     * Get InformasiUmum by name
     *
     * @param string $name
     * @return Collection
     */
    public function getByName(string $name): Collection
    {
        return $this->getQuery()->where('nama', 'like', "%{$name}%")->get();
    }

    /**
     * Get InformasiUmum by jenis wajib pajak
     *
     * @param string $jenisWajibPajak
     * @return Collection
     */
    public function getByJenisWajibPajak(string $jenisWajibPajak): Collection
    {
        return $this->getQuery()->where('jenis_wajib_pajak', $jenisWajibPajak)->get();
    }
}
