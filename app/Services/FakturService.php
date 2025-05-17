<?php

namespace App\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\KodeTransaksi;
use App\Models\AssignmentUser;
use App\Models\SistemTambahan;
use App\Models\DetailTransaksi;
use App\Support\Enums\IntentEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FakturResource;
use App\Support\Enums\FakturStatusEnum;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\FakturServiceInterface;
use App\Support\Interfaces\Repositories\FakturRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class FakturService extends BaseCrudService implements FakturServiceInterface {
    protected function getRepositoryClass(): string {
        return FakturRepositoryInterface::class;
    }

    public function create(array $data , ?Sistem $sistem = null  ): ?Model {
        $kodeTransaksi = KodeTransaksi::where('kode', $data['kode_transaksi'])->first();

        $randomNumber = '0'. $kodeTransaksi->kode .'-0-' . mt_rand(000000000000000, 999999999999999);

        $data['nomor_faktur_pajak'] = $randomNumber;
        $data['sistem_id'] = $sistem->id;

        if ($sistem) {
            $data['akun_pengirim_id'] = $sistem->id;
        }

        $intent = $data['intent'] ?? null;
        unset($data['intent']);

        switch ($intent) {
            case IntentEnum::API_CREATE_FAKTUR_DRAFT->value:
                $data['is_draft'] = true;
                $data['status'] = FakturStatusEnum::DRAFT->value;
                break;
            case IntentEnum::API_CREATE_FAKTUR_FIX->value:
                $data['is_draft'] = false;
                $data['esign_status'] = 'DONE';
                $data['status'] = FakturStatusEnum::APPROVED->value;
                break;
            default:
                // Default behavior (no specific intent)
                break;
        }

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

    public function update($keyOrModel, array $data): ?Model
    {
        $detailTransaksiData = $data['detail_transaksi'] ?? null;
        unset($data['detail_transaksi']);

        return DB::transaction(function () use ($keyOrModel, $data, $detailTransaksiData) {
            $intent = $data['intent'] ?? null;
            unset($data['intent']);

            switch ($intent) {
                case IntentEnum::API_UPDATE_FAKTUR_FIX->value:
                    $data['is_draft'] = false;
                    $data['esign_status'] = 'DONE';
                    $data['status'] = FakturStatusEnum::APPROVED->value;
                    break;
                default:
                    // Default behavior (no specific intent)
                    break;
            }

            if ($keyOrModel->is_draft == false){
                $dataFakturOld = Faktur::where('id', $keyOrModel->id)->first();

                $dataFakturOld['status'] = FakturStatusEnum::AMENDED->value;
                $dataFakturOld->save();

                $dataFakturNew = $dataFakturOld->toArray();
                unset($dataFakturNew['id'], $dataFakturNew['created_at'], $dataFakturNew['updated_at']);

                $parts = explode('-', $dataFakturNew['nomor_faktur_pajak']);
                if (isset($parts[1]) && $parts[1] === '0') {
                    $parts[1] = '1';
                }

                $dataFakturNew['nomor_faktur_pajak'] = implode('-', $parts);
                $dataFakturNew['status'] = FakturStatusEnum::APPROVED->value;
                $faktur = parent::create($dataFakturNew);
            } else {
                $faktur = parent::update($keyOrModel, $data);
            }


            if ($detailTransaksiData && is_array($detailTransaksiData)) {
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

                // Optional: Delete any detail transaksi not in the request
                DetailTransaksi::where('faktur_id', $faktur->id)
                    ->whereNotIn('id', $existingIds)
                    ->delete();
            }

            return $faktur;
        });
    }



    public function addDetailTransaksi(Faktur $faktur, array $detailTransaksiData)
    {
        if (!is_object($faktur)) {
            $faktur = $this->repository->find($faktur);
        }

        $detailTransaksiData['faktur_id'] = $faktur->id;
        return DetailTransaksi::create($detailTransaksiData);
    }

    public function deleteDetailTransaksi(Faktur $faktur, $detailTransaksi)
    {
        if (!is_object($detailTransaksi)) {
            $detailTransaksi = DetailTransaksi::findOrFail($detailTransaksi);
        }

        return $detailTransaksi->delete();
    }

    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    ) {
        $this->authorizeAccess($assignment, $sistem);

        $intent = $request->query('intent');

        switch ($intent) {
            case IntentEnum::API_GET_FAKTUR_PENGIRIM->value:
                $filters = array_merge($request->query(), ['akun_pengirim_id' => $sistem->id]);
                break;

            case IntentEnum::API_GET_FAKTUR_PENERIMA->value:
                $filters = array_merge($request->query(),
                [
                    'akun_penerima_id' => $sistem->id,
                    'is_draft' => false
                ]);

                break;

            default:
                $filters = array_merge($request->query(), ['akun_pengirim_id' => $sistem->id]);
                break;
        }

        return $this->getAllPaginated($filters, $perPage);
    }

    public function authorizeAccess(Assignment $assignment, Sistem $sistem): void
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

    public function authorizeFakturBelongsToSistem(Faktur $faktur, Sistem $sistem): void
    {
        if ($faktur->akun_pengirim_id !== $sistem->id) {
            abort(403, 'Unauthorized access to this faktur');
        }
    }

        // public function update($keyOrModel, array $data): ?Model {
    //     $detailTransaksiData = $data['detail_transaksi'] ?? null;
    //     unset($data['detail_transaksi']);

    //     return DB::transaction(function () use ($keyOrModel, $data, $detailTransaksiData) {
    //         // Update the faktur
    //         $faktur = parent::update($keyOrModel, $data);

    //         // Split the nomor_faktur_pajak by '-'
    //         $parts = explode('-', $faktur->nomor_faktur_pajak);

    //             // Check if the second part exists and is '0', then change it to '1'
    //         if (isset($parts[1]) && $parts[1] === '0') {
    //             $parts[1] = '1';
    //         }

    //             // Join the parts back together
    //         $faktur->nomor_faktur_pajak = implode('-', $parts);
    //         $faktur->save();

    //         // Initialize totals
    //         // $detailTransaksiData = $data['detail_transaksi'] ?? null;
    //         // unset($data['detail_transaksi']);

    //         if ($detailTransaksiData && is_array($detailTransaksiData)) {
    //             // Process existing and new detail transaksi
    //             $existingIds = [];

    //             foreach ($detailTransaksiData as $transaksi) {
    //                 if (isset($transaksi['id'])) {
    //                     // Update existing detail transaksi
    //                     $detailTransaksi = DetailTransaksi::find($transaksi['id']);
    //                     if ($detailTransaksi && $detailTransaksi->faktur_id == $faktur->id) {
    //                         $detailTransaksi->update($transaksi);
    //                         $existingIds[] = $detailTransaksi->id;
    //                     }
    //                 } else {
    //                     // Create new detail transaksi
    //                     $transaksi['faktur_id'] = $faktur->id;
    //                     $newDetail = DetailTransaksi::create($transaksi);
    //                     $existingIds[] = $newDetail->id;
    //                 }
    //             }

    //             // Optional: Delete any detail transaksi not in the request
    //             DetailTransaksi::where('faktur_id', $faktur->id)
    //                 ->whereNotIn('id', $existingIds)
    //                 ->delete();
    //         }

    //         return $faktur;
    //     });
    // }
}