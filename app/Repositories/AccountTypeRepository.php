<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\AccountType;
use App\Support\Interfaces\Repositories\AccountTypeRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;

class AccountTypeRepository extends BaseRepository implements AccountTypeRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return AccountType::class;
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