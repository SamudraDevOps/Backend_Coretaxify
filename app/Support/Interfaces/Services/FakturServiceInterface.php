<?php

namespace App\Support\Interfaces\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface FakturServiceInterface extends BaseCrudServiceInterface {

    public function create(array $data , ?Sistem $sistem = null  ): ?Model;

    public function authorizeFakturBelongsToSistem(Faktur $faktur, Sistem $sistem);

    public function authorizeAccess(Assignment $assignment, Sistem $sistem);

    public function update($keyOrModel, array $data): ?Model;

    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    );
    //  /**
    //  * Add a detail transaksi to a faktur
    //  */
    // public function addDetailTransaksi(Faktur $faktur, array $data);

    // /**
    //  * Delete a detail transaksi from a faktur
    //  */
    // public function deleteDetailTransaksi(Faktur $faktur, $detailTransaksiId): bool;

}
