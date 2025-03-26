<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\Assignment;
use App\Models\DetailBank;
use App\Models\Sistem;
use App\Support\Interfaces\Repositories\DetailBankRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DetailBankRepository extends BaseRepository implements DetailBankRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string
    {
        return DetailBank::class;
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

        // Apply search filters for DetailBank fields
        $query = $this->applySearchFilters($query, $searchParams, [
            'nama_bank',
            'nomor_rekening_bank',
            'jenis_rekening_bank'
        ]);

        // Apply column filters
        $query = $this->applyColumnFilters($query, $searchParams, [
            'id',
            'sistem_id'
        ]);

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
     * Get DetailBank by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->find($id);
    }

    /**
     * Get DetailBank by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {

        return $this->model->where('sistem_id', $sistemId)->get();
    }

    /**
     * Get DetailBank by nama bank
     *
     * @param string $namaBank
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNamaBank(string $namaBank, ?int $sistemId = null): Collection
    {
        $query = $this->model->newQuery()->where('nama_bank', 'like', "%{$namaBank}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get DetailBank by nomor rekening
     *
     * @param string $nomorRekening
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNomorRekening(string $nomorRekening, ?int $sistemId = null): Collection
    {
        $query = $this->model->newQuery()->where('nomor_rekening_bank', 'like', "%{$nomorRekening}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get DetailBank by jenis rekening
     *
     * @param string $jenisRekening
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisRekening(string $jenisRekening, ?int $sistemId = null): Collection
    {
        $query = $this->model->newQuery()->where('jenis_rekening_bank', $jenisRekening);

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }
}
