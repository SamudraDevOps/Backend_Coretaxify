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

        $user = auth()->user();

        if ($user->hasRole('mahasiswa') || $user->hasRole('dosen')) {
            $limitResponse = $this->checkLimit($user);
            if ($limitResponse) {
                return $limitResponse;
            }
        }

        $kodeTransaksi = KodeTransaksi::where('kode', $data['kode_transaksi'])->first();

        $randomNumber = '0'. $kodeTransaksi->kode .'-0-' . mt_rand(000000000000000, 999999999999999);

        $data['nomor_faktur_pajak'] = $randomNumber;
        $data['badan_id'] = $sistem->id;

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

            $this->recalculateFakturTotals($faktur);
            return $faktur;
        });
    }

    public function update($keyOrModel, array $data): ?Model
    {
        $detailTransaksiData = $data['detail_transaksi'] ?? null;
        unset($data['detail_transaksi']);

        $intent = $data['intent'] ?? null;

        switch ($intent) {
            case IntentEnum::API_UPDATE_FAKTUR_KREDITKAN->value:
                $data['is_kredit'] = true;
                return parent::update($keyOrModel, $data);
                // break;
            case IntentEnum::API_UPDATE_FAKTUR_TIDAK_KREDITKAN->value:
                $data['is_kredit'] = false;
                return parent::update($keyOrModel, $data);
                // break;
            case IntentEnum::API_UPDATE_FAKTUR_RETUR_MASUKAN->value:
                $randomNumber = mt_rand(100000000000000, 999999999999999);
                $noRetur = 'RET'. $randomNumber;

                $data['is_retur'] = true;
                $data['nomor_retur'] = $noRetur;

                if (isset($data['tanggal_retur']) && !empty($data['tanggal_retur'])) {
                    $tanggalRetur = \Carbon\Carbon::parse($data['tanggal_retur']);

                    $namaBulan = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];

                    $data['masa_pajak_retur'] = $namaBulan[$tanggalRetur->month];
                    $data['tahun_retur'] = $tanggalRetur->year;
                }

                $faktur = parent::update($keyOrModel, $data);

                $this->recalculateReturTotals($faktur);

                return $faktur;
        }

        return DB::transaction(function () use ($keyOrModel, $data, $detailTransaksiData) {

            $intent = $data['intent'] ?? null;
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

            if ($keyOrModel->is_draft == false) {
                $dataFakturOld = Faktur::where('id', $keyOrModel->id)->first();

                $dataFakturOld->status = FakturStatusEnum::AMENDED->value;
                $dataFakturOld->save();

                $dataFakturNew = $dataFakturOld->toArray();
                unset($dataFakturNew['id'], $dataFakturNew['created_at'], $dataFakturNew['updated_at']);

                $parts = explode('-', $dataFakturNew['nomor_faktur_pajak']);
                if (isset($parts[1]) && $parts[1] === '0') {
                    $parts[1] = '1';
                }
                $dataFakturNew['nomor_faktur_pajak'] = implode('-', $parts);

                $dataFakturNew = array_merge($dataFakturNew, $data);
                $dataFakturNew['status'] = FakturStatusEnum::APPROVED->value;

                $fakturBaru = parent::create($dataFakturNew);

                $this->duplicateDetailTransaksi($dataFakturOld->id, $fakturBaru->id);

                $this->recalculateFakturTotals($fakturBaru);

                return $fakturBaru;
            } else {
                $faktur = parent::update($keyOrModel, $data);

                $this->recalculateFakturTotals($faktur);

                return $faktur;
            }
        });
    }

    public function getAllForSistem(Assignment $assignment, Sistem $sistem, Request $request,int $perPage = 5) {
        $this->authorizeAccess($assignment, $sistem, $request);

        $intent = $request->query('intent');

        switch ($intent) {
            case IntentEnum::API_GET_FAKTUR_PENGIRIM->value:
                $filters = array_merge($request->query(), ['akun_pengirim_id' => $sistem->id]);
                break;
            case IntentEnum::API_GET_FAKTUR_PENERIMA->value:
                $filters = array_merge($request->query(),
                [
                    'status' => FakturStatusEnum::APPROVED->value,
                    'akun_penerima_id' => $sistem->id,
                    'is_draft' => false
                ]);
                break;
            case IntentEnum::API_GET_FAKTUR_MASUKAN_BY_NOMOR_FAKTUR->value:
                $filters = array_merge($request->query(),
                [
                    'akun_penerima_id' => $sistem->id,
                    'is_draft' => false
                ]);
                break;
            case IntentEnum::API_GET_FAKTUR_RETUR_KELUARAN->value:
                $filters = array_merge([
                    'akun_pengirim_id' => $sistem->id,
                    'is_retur' => true
                ], $request->query());
                break;
            case IntentEnum::API_GET_FAKTUR_RETUR_MASUKAN->value:
                $filters = array_merge($request->query(),
                [
                    'akun_penerima_id' => $sistem->id,
                    'is_retur' => true,
                    'is_kredit' => true,
                ]);
                break;
            default:
                $filters = array_merge($request->query(), ['akun_pengirim_id' => $sistem->id]);
                break;
        }

        return $this->getAllPaginated($filters, $perPage);
    }

    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Request $request): void
    {
        $user_id = $request->get('user_id');

        $assignmentUser = AssignmentUser::where([
            'user_id' => $user_id ?? Auth::id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if (($sistem->assignment_user_id !== $assignmentUser->id) && !$user_id) {
            abort(403, 'Unauthorized access to this sistem');
        }
        // Verify the sistem exists for this assignment user
        Sistem::where('assignment_user_id', $assignmentUser->id)
        ->where('id', $sistem->id)
        ->firstOrFail();
    }

    public function authorizeFakturBelongsToSistem(Faktur $faktur, Sistem $sistem, Request $request): void
    {
        $user_id = $request->get('user_id');
        if (($faktur->akun_pengirim_id !== $sistem->id) && !$user_id) {
            abort(403, 'Unauthorized access to this faktur');
        }
    }

    private function duplicateDetailTransaksi(int $fakturLamaId, int $fakturBaruId): void
    {
        $detailTransaksiLama = DetailTransaksi::where('faktur_id', $fakturLamaId)->get();

        foreach ($detailTransaksiLama as $detail) {
            $detailArray = $detail->toArray();
            unset($detailArray['id'], $detailArray['created_at'], $detailArray['updated_at']);
            $detailArray['faktur_id'] = $fakturBaruId;
            $detailArray['is_tambahan'] = false;
            $detailArray['is_lama'] = false;
            $detailArray['tipe_lama'] = null;
            $detailArray['nama_lama'] = null;
            $detailArray['kode_lama'] = null;
            $detailArray['kuantitas_lama'] = null;
            $detailArray['satuan_lama'] = null;
            $detailArray['harga_satuan_lama'] = null;
            $detailArray['total_harga_lama'] = null;
            $detailArray['pemotongan_harga_lama'] = null;
            $detailArray['dpp_lama'] = null;
            $detailArray['ppn_lama'] = null;
            $detailArray['dpp_lain_lama'] = null;
            $detailArray['ppnbm_lama'] = null;
            $detailArray['ppn_retur_lama'] = null;
            $detailArray['dpp_lain_retur_lama'] = null;
            $detailArray['ppnbm_retur_lama'] = null;
            $detailArray['tarif_ppnbm_lama'] = null;
            DetailTransaksi::create($detailArray);
        }

        DetailTransaksi::where('faktur_id', $fakturLamaId)
                        ->where('is_tambahan', true)
                        ->forceDelete();
    }

    public function getDashboardData($assignment, $sistem)
    {
        $getFakturKeluaran = Faktur::where('akun_pengirim_id', $sistem->id)->count();
        $getFakturMasukan = Faktur::where('akun_penerima_id', $sistem->id)->where('status', FakturStatusEnum::APPROVED->value)->count();

        $getFakturKeluaranAmended = Faktur::where('akun_pengirim_id', $sistem->id)->where('status', FakturStatusEnum::AMENDED->value)->count();
        $getFakturKeluaranDraft = Faktur::where('akun_pengirim_id', $sistem->id)->where('status', FakturStatusEnum::DRAFT->value)->count();
        $getFakturKeluaranCanceled = Faktur::where('akun_pengirim_id', $sistem->id)->where('status', FakturStatusEnum::CANCELED->value)->count();
        $getFakturKeluaranApproved = Faktur::where('akun_pengirim_id', $sistem->id)->where('status', FakturStatusEnum::APPROVED->value)->count();

        $allFaktur = $getFakturKeluaran + $getFakturMasukan;

        return [
            'faktur_keluaran_amended' => $getFakturKeluaranAmended,
            'faktur_keluaran_draft' => $getFakturKeluaranDraft,
            'faktur_keluaran_canceled' => $getFakturKeluaranCanceled,
            'faktur_keluaran_approved' => $getFakturKeluaranApproved,
            'faktur_masukan' => $getFakturMasukan,
            'all_faktur' => $allFaktur
        ];
    }

    private function recalculateFakturTotals($faktur): void
    {
        $detailTransaksis = DetailTransaksi::where('faktur_id', $faktur->id)->get();

        $totals = [
            'ppn' => $detailTransaksis->sum('ppn'),
            'ppnbm' => $detailTransaksis->sum('ppnbm'),
            'dpp' => $detailTransaksis->sum('dpp'),
            'dpp_lain' => $detailTransaksis->sum('dpp_lain'),
        ];

        parent::update($faktur, $totals);
    }

    private function recalculateReturTotals($faktur): void
    {
        $detailTransaksis = DetailTransaksi::where('faktur_id', $faktur->id)->get();

        $returTotals = [
            'ppn_retur' => $detailTransaksis->sum('ppn_retur') * -1,
            'dpp_lain_retur' => $detailTransaksis->sum('dpp_lain_retur') * -1,
            'ppnbm_retur' => $detailTransaksis->sum('ppnbm_retur') * -1,
        ];

        parent::update($faktur, $returTotals);
    }

    private function getContractFakturLimit($user)
    {
        return $user->contract->faktur;
    }

    private function getContractFakturCount($contract)
    {
        return Faktur::whereHas('akun_pengirim', function ($query) use ($contract) {
            $query->whereHas('assignment_user', function ($subQuery) use ($contract) {
                $subQuery->whereHas('user', function ($userQuery) use ($contract) {
                    $userQuery->where('contract_id', $contract->id);
                });
            });
        })->count();
    }

    private function checkLimit($user)
    {
        $limit = $this->getContractFakturLimit($user);
        $contractFakturCount = $this->getContractFakturCount($user->contract);

        if ($contractFakturCount >= $limit) {
            return response()->json([
                'message' => "Batas pembuatan E-Faktur sebanyak {$limit} telah tercapai.",
            ], 422);
        }

        return null;
    }
}
