<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotRepositoryInterface;
use App\Support\Interfaces\Services\BupotServiceInterface;
use Illuminate\Database\Eloquent\Model;

class BupotService extends BaseCrudService implements BupotServiceInterface
{
    protected function getRepositoryClass(): string
    {
        return BupotRepositoryInterface::class;
    }

    public function create(array $data): ?Model
    {
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

}
