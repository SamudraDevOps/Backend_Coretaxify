<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotRepositoryInterface;
use App\Support\Interfaces\Services\BupotServiceInterface;
use Illuminate\Database\Eloquent\Model;

class BupotService extends BaseCrudService implements BupotServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $data['nomor_pemotongan'] = $this->generateNomorPemotongan();

        return parent::create($data);
    }

    private function generateNomorPemotongan() {
        $string1 = rand(0000, 9999);
        $string2 = strtoupper(str()->random(5));

        return $string1 . $string2;
    }

    public function penerbitan(array $data) {
        if(!isset($data['id'])) {
            foreach($data['id'] as $id) {
                $bupot = $this->repository->find($id);
                if($bupot->status_penerbitan = 'disimpan') {
                    $bupot->status = 'terbit';
                } else if ($bupot->status_penerbitan = 'disimpan tidak valid') {
                    return response()->json([
                        'message' => 'BUPOT tidak dapat diterbitkan karena statusnya disimpan tidak valid'
                    ], 422);
                }
                $bupot->status_penerbitan = 'terbit';
                $bupot->save();
            }
        }
    }

    public function penghapusan(array $data) {
        if(!isset($data['id'])) {
            foreach($data['id'] as $id) {
                $bupot = $this->repository->find($id);
                if($bupot->status_penerbitan = 'terbit') {
                    $bupot->status = 'pembatalan';
                } else if ($bupot->status_penerbitan = 'disimpan' || $bupot->status_penerbitan = 'disimpan tidak valid') {
                    $bupot->status = 'dihapus';
                }
                $bupot->status_penerbitan = 'tidak valid';
                $bupot->save();
            }
        }
    }
}
