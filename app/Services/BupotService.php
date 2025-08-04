<?php

namespace App\Services;

use App\Models\Bupot;
use App\Models\Sistem;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\BupotServiceInterface;
use App\Support\Interfaces\Repositories\BupotRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class BupotService extends BaseCrudService implements BupotServiceInterface
{
    protected function getRepositoryClass(): string
    {
        return BupotRepositoryInterface::class;
    }

    public function create(array $data): ?Model
    {
        $user = auth()->user();

        if ($user->hasRole('mahasiswa') || $user->hasRole('dosen')) {
            $limitResponse = $this->checkLimit($user);
            if ($limitResponse) {
                return $limitResponse;
            }
        }

        $data['nomor_pemotongan'] = $this->generateNomorPemotongan();

        return parent::create($data);
    }

    private function generateNomorPemotongan()
    {
        $string1 = rand(0000, 9999);
        $string2 = strtoupper(str()->random(5));

        return $string1 . $string2;
    }

    public function penerbitan(array $data)
    {
        if (isset($data['ids'])) { // Changed from !isset to isset
            $successCount = 0;
            $errors = [];

            foreach ($data['ids'] as $id) {
                $bupot = $this->repository->find($id);

                if (!$bupot) {
                    $errors[] = "BUPOT dengan ID {$id} tidak ditemukan";
                    continue;
                }

                if ($bupot->status_penerbitan == 'draft' && ($bupot->status == 'normal' || $bupot->status == 'pembetulan')) {
                    $bupot->status_penerbitan = 'published'; // Changed from == to =
                    $bupot->save();

                    $idAssigmentObj = Sistem::where('id', $bupot->pembuat_id)->first();
                    $idAssigment = $idAssigmentObj ? $idAssigmentObj->assignment_user_id : null;
                    $idSistemPembuatObj = Sistem::where('assignment_user_id', $idAssigment)
                        ->where('npwp_akun', $bupot->npwp_akun)->first();
                    $idSistemPembuat = $idSistemPembuatObj ? $idSistemPembuatObj->id : null;

                    if ($idSistemPembuat) {
                        try {
                            Notification::create([
                                'sistem_id' => $idSistemPembuat,
                                'pengirim' => $bupot->pembuat->nama_akun,
                                'subjek' => 'Anda Menerima Bukti Pemotongan/Pemungutan baru. Silahkan cek detail',
                                'isi' => 'Anda menerima Bukti Pemotongan/Pemungutan baru. Detil pemotongan/pemungutan sebagai berikut: Nomor Pemotongan/Pemungutan: ' . ($bupot->nomor_pemotongan ?? '-') . '. NPWP/NIK Pemotong/Pemungut: ' . ($bupot->npwp_akun ?? '-') . '. Nama Pemotong/Pemungut: ' . ($bupot->nama_akun ?? '-') . '. Dpp: ' . ($bupot->dasar_pengenaan_pajak ?? 0) . ' PPh yang Dipotong/Dipungut: ' . ($bupot->pajak_penghasilan ?? 0) . '. Regards, ' . ($bupot->pembuat->nama_akun ?? '-'),
                            ]);
                        } catch (\Exception $e) {
                            // return response()->json([
                            //     'message' => "Berhasil menerbitkan {$successCount} BUPOT (tanpa notifikasi)",
                            // ], 200);
                        }
                    } else {
                        // Jika idSistemPembuat null, tetap return 200
                        // return response()->json([
                        //     'message' => "Berhasil menerbitkan {$successCount} BUPOT (tanpa notifikasi)",
                        // ], 200);
                    }

                    $successCount++;
                } else if ($bupot->status_penerbitan == 'draft' && $bupot->status == 'invalid') {
                    $errors[] = "BUPOT dengan ID {$id} tidak dapat diterbitkan karena statusnya invalid";
                } else {
                    $errors[] = "BUPOT dengan ID {$id} tidak dapat diterbitkan (status: {$bupot->status_penerbitan})";
                }
            }

            if ($successCount > 0 && empty($errors)) {
                return response()->json([
                    'message' => "Berhasil menerbitkan {$successCount} BUPOT"
                ], 200);
            } else if ($successCount > 0 && !empty($errors)) {
                return response()->json([
                    'message' => "Berhasil menerbitkan {$successCount} BUPOT, namun ada beberapa error",
                    'errors' => $errors
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Tidak ada BUPOT yang dapat diterbitkan',
                    'errors' => $errors
                ], 422);
            }
        }

        return response()->json([
            'message' => 'Data IDs tidak ditemukan'
        ], 400);
    }

    public function penghapusan(array $data)
    {
        if (isset($data['ids'])) { // Changed from !isset to isset
            $successCount = 0;
            $errors = [];

            foreach ($data['ids'] as $id) {
                $bupot = $this->repository->find($id);

                if (!$bupot) {
                    $errors[] = "BUPOT dengan ID {$id} tidak ditemukan";
                    continue;
                }

                if ($bupot->status_penerbitan == 'published') { // Changed from = to ==
                    $bupot->status = 'pembatalan';
                    $bupot->status_penerbitan = 'invalid'; // Changed from = to =
                    $bupot->save();
                    $successCount++;
                } else if ($bupot->status_penerbitan == 'draft') {
                    $bupot->status = 'dihapus';
                    $bupot->status_penerbitan = 'invalid'; // Changed from = to =
                    $bupot->save();
                    $successCount++;
                } else {
                    $errors[] = "BUPOT dengan ID {$id} tidak dapat dihapus (status: {$bupot->status_penerbitan})";
                }
            }

            if ($successCount > 0 && empty($errors)) {
                return response()->json([
                    'message' => "Berhasil menghapus {$successCount} BUPOT"
                ], 200);
            } else if ($successCount > 0 && !empty($errors)) {
                return response()->json([
                    'message' => "Berhasil menghapus {$successCount} BUPOT, namun ada beberapa error",
                    'errors' => $errors
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Tidak ada BUPOT yang dapat dihapus',
                    'errors' => $errors
                ], 422);
            }
        }

        return response()->json([
            'message' => 'Data IDs tidak ditemukan'
        ], 400);
    }

    private function getContractBupotLimit($user)
    {
        return $user->contract->bupot;
    }

    private function getContractBupotCount($contract)
    {
        return Bupot::whereHas('pembuat', function ($query) use ($contract) {
            $query->whereHas('assignment_user', function ($subQuery) use ($contract) {
                $subQuery->whereHas('user', function ($userQuery) use ($contract) {
                    $userQuery->where('contract_id', $contract->id);
                });
            });
        })->count();
    }

    private function checkLimit($user)
    {
        $limit = $this->getContractBupotLimit($user);
        $contractBupotCount = $this->getContractBupotCount($user->contract);

        if ($contractBupotCount >= $limit) {
            return response()->json([
                'message' => "Batas pembuatan Bupot sebanyak {$limit} telah tercapai.",
            ], 422);
        }

        return null;
    }
}
