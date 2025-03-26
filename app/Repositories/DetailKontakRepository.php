<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\DetailKontak;
use App\Support\Interfaces\Repositories\DetailKontakRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DetailKontakRepository extends BaseRepository implements DetailKontakRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return DetailKontak::class;
    }

    /**
     * Apply filters to the query
     *
     * @param array $searchParams
     * @return Builder
     */
    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        // Apply search filters for contact fields
        $query = $this->applySearchFilters($query, $searchParams, [
            'jenis_kontak',
            'nomor_telpon',
            'nomor_handphone',
            'alamat_email'
        ]);

        // Apply column filters
        $query = $this->applyColumnFilters($query, $searchParams, ['id', 'sistem_id', 'jenis_kontak']);

        // Explicitly handle sistem_id filtering if it exists in searchParams
        if (isset($searchParams['sistem_id'])) {
            $query->where('sistem_id', $searchParams['sistem_id']);
        }

        // Apply date range filters
        if (isset($searchParams['tanggal_mulai_from']) && isset($searchParams['tanggal_mulai_to'])) {
            $query->whereBetween('tanggal_mulai', [
                $searchParams['tanggal_mulai_from'],
                $searchParams['tanggal_mulai_to']
            ]);
        }

        if (isset($searchParams['tanggal_berakhir_from']) && isset($searchParams['tanggal_berakhir_to'])) {
            $query->whereBetween('tanggal_berakhir', [
                $searchParams['tanggal_berakhir_from'],
                $searchParams['tanggal_berakhir_to']
            ]);
        }

        // Apply relations
        $query = $this->applyResolvedRelations($query, $searchParams);

        // Apply sorting
        $query = $this->applySorting($query, $searchParams);

        return $query;
    }

    /**
     * Get DetailKontak by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * Get DetailKontak by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->getQuery()->where('sistem_id', $sistemId)->get();
    }

    /**
     * Get DetailKontak by jenis kontak
     *
     * @param string $jenisKontak
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisKontak(string $jenisKontak, ?int $sistemId = null): Collection
    {
        $query = $this->getQuery()->where('jenis_kontak', $jenisKontak);

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get DetailKontak by email
     *
     * @param string $email
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByEmail(string $email, ?int $sistemId = null): Collection
    {
        $query = $this->getQuery()->where('alamat_email', 'like', "%{$email}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get DetailKontak by phone number
     *
     * @param string $phoneNumber
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByPhoneNumber(string $phoneNumber, ?int $sistemId = null): Collection
    {
        $query = $this->getQuery()->where(function($q) use ($phoneNumber) {
            $q->where('nomor_telpon', 'like', "%{$phoneNumber}%")
              ->orWhere('nomor_handphone', 'like', "%{$phoneNumber}%");
        });

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }
}