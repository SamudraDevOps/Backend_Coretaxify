<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\DetailBank;
use App\Support\Interfaces\Repositories\DetailBankRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;

class DetailBankRepository extends BaseRepository implements DetailBankRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return DetailBank::class;
    }

    protected function applyFilters(array $searchParams = []): Builder {
        $query = $this->getQuery();

        $query = $this->applySearchFilters($query, $searchParams, ['name']);

        $query = $this->applyColumnFilters($query, $searchParams, ['id']);

        $query = $this->applyResolvedRelations($query, $searchParams);

        $query = $this->applySorting($query, $searchParams);

        return $query;
    }
}