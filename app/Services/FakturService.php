<?php

namespace App\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\FakturServiceInterface;
use App\Support\Interfaces\Repositories\FakturRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class FakturService extends BaseCrudService implements FakturServiceInterface {
    protected function getRepositoryClass(): string {
        return FakturRepositoryInterface::class;
    }

    public function create(array $data , ?Sistem $sistem = null  ): ?Model {
        $randomNumber = '01-0-' . mt_rand(000000000000000, 999999999999999);

        $data['nomor_faktur_pajak'] = $randomNumber;

        if ($sistem) {
            $data['akun_pengirim'] = $sistem->id;
        }

        // Extract detail_transaksi data if it exists
        $detailTransaksiData = $data['detail_transaksi'] ?? null;
        unset($data['detail_transaksi']);

        // Use database transaction to ensure data integrity
        return DB::transaction(function () use ($data, $detailTransaksiData) {
            // Create the faktur
            $faktur = parent::create($data);

            // Create detail transaksi if provided
            if ($detailTransaksiData && is_array($detailTransaksiData)) {
                foreach ($detailTransaksiData as $transaksi) {
                    $transaksi['faktur_id'] = $faktur->id;
                    DetailTransaksi::create($transaksi);
                }
            }

            return $faktur;
        });
    }

    public function update($keyOrModel, array $data): ?Model {
        $detailTransaksiData = $data['detail_transaksi'] ?? null;
        unset($data['detail_transaksi']);

        return DB::transaction(function () use ($keyOrModel, $data, $detailTransaksiData) {
            // Update the faktur
            $faktur = parent::update($keyOrModel, $data);

            // Handle detail transaksi if provided
            if ($detailTransaksiData && is_array($detailTransaksiData)) {
                // Process existing and new detail transaksi
                $existingIds = [];

                foreach ($detailTransaksiData as $transaksi) {
                    if (isset($transaksi['id'])) {
                        // Update existing detail transaksi
                        $detailTransaksi = DetailTransaksi::find($transaksi['id']);
                        if ($detailTransaksi && $detailTransaksi->faktur_id == $faktur->id) {
                            $detailTransaksi->update($transaksi);
                            $existingIds[] = $detailTransaksi->id;
                        }
                    } else {
                        // Create new detail transaksi
                        $transaksi['faktur_id'] = $faktur->id;
                        $newDetail = DetailTransaksi::create($transaksi);
                        $existingIds[] = $newDetail->id;
                    }
                }

                // Delete any detail transaksi not in the request (optional)
                // Uncomment if you want to remove details not included in the update
                // DetailTransaksi::where('faktur_id', $faktur->id)
                //     ->whereNotIn('id', $existingIds)
                //     ->delete();
            }

            return $faktur;
        });
    }

    public function addDetailTransaksi($faktur, array $detailTransaksiData)
    {
        if (!is_object($faktur)) {
            $faktur = $this->repository->find($faktur);
        }

        $detailTransaksiData['faktur_id'] = $faktur->id;
        return DetailTransaksi::create($detailTransaksiData);
    }

    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    ) {
        $this->authorizeAccess($assignment, $sistem);

        $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);

        return $this->getAllPaginated($filters, $perPage);
    }

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
