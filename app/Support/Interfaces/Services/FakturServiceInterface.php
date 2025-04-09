<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;

interface FakturServiceInterface extends BaseCrudServiceInterface {

    public function create(array $data , ?Sistem $sistem = null  ): ?Model;

    public function addDetailTransaksi(Faktur $faktur, array $detailTransaksiData);

    public function deleteDetailTransaksi($detailTransaksi);

    public function update($keyOrModel, array $data): ?Model;

    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    );

}