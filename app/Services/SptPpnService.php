<?php

namespace App\Services;

use App\Models\Pic;
use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\SptPpn;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use App\Support\Enums\SptPpnEnum;
use Illuminate\Support\Facades\Auth;
use App\Support\Enums\FakturStatusEnum;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\SptPpnServiceInterface;
use App\Support\Interfaces\Repositories\SptPpnRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SptPpnService extends BaseCrudService implements SptPpnServiceInterface {
    protected function getRepositoryClass(): string {
        return SptPpnRepositoryInterface::class;
    }

    public function create(array $data): Model {

        $intent = $data['intent'] ?? null;
            unset($data['intent']);

            switch ($intent) {
                case IntentEnum::API_CREATE_SPT_PPN_BAYAR->value:
                    $data['is_pembetulan'] = true;
                    $data['status'] = SptPpnEnum::DILAPORKAN->value;
                    break;
                default:
                    $data['is_pembetulan'] = false ;
                    $data['status'] = SptPpnEnum::DIBUAT->value;
                    break;
            }

        //alur normal
        $periode = $data['periode'];

        [$month, $year] = explode(' ', $periode, 2);

        $fakturs = Faktur::where('pic_id', $data['pic_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->get();

        // $data['cl_1a2_dpp'] dokumen lain

        $fakturs1a2 = $fakturs->whereIn('kode_transaksi', [4, 5]);
        $data['cl_1a2_dpp']      = $fakturs1a2->sum('dpp');
        $data['cl_1a2_dpp_lain'] = $fakturs1a2->sum('dpp_lain');
        $data['cl_1a2_ppn']      = $fakturs1a2->sum('ppn');
        $data['cl_1a2_ppnbm']    = $fakturs1a2->sum('ppnbm');

        $fakturs1a3 = $fakturs->where('kode_transaksi', 6);
        $data['cl_1a3_dpp']      = $fakturs1a3->sum('dpp');
        $data['cl_1a3_dpp_lain'] = $fakturs1a3->sum('dpp_lain');
        $data['cl_1a3_ppn']      = $fakturs1a3->sum('ppn');
        $data['cl_1a3_ppnbm']    = $fakturs1a3->sum('ppnbm');

        $fakturs1a4 = $fakturs->whereIn('kode_transaksi', [1, 9, 10]);
        $data['cl_1a4_dpp']      = $fakturs1a4->sum('dpp');
        $data['cl_1a4_ppn']      = $fakturs1a4->sum('ppn');
        $data['cl_1a4_ppnbm']    = $fakturs1a4->sum('ppnbm');

        $fakturs1a6 = $fakturs->whereIn('kode_transaksi', [2, 3]);
        $data['cl_1a6_dpp']      = $fakturs1a6->sum('dpp');
        $data['cl_1a6_dpp_lain'] = $fakturs1a6->sum('dpp_lain');
        $data['cl_1a6_ppn']      = $fakturs1a6->sum('ppn');
        $data['cl_1a6_ppnbm']    = $fakturs1a6->sum('ppnbm');

        $fakturs1a7 = $fakturs->where('kode_transaksi', 6);
        $data['cl_1a7_dpp']      = $fakturs1a7->sum('dpp');
        $data['cl_1a7_dpp_lain'] = $fakturs1a7->sum('dpp_lain');
        $data['cl_1a7_ppn']      = $fakturs1a7->sum('ppn');
        $data['cl_1a7_ppnbm']    = $fakturs1a7->sum('ppnbm');

        $fakturs1a8 = $fakturs->where('kode_transaksi', 8);
        $data['cl_1a8_dpp']      = $fakturs1a8->sum('dpp');
        $data['cl_1a8_dpp_lain'] = $fakturs1a8->sum('dpp_lain');
        $data['cl_1a8_ppn']      = $fakturs1a8->sum('ppn');
        $data['cl_1a8_ppnbm']    = $fakturs1a8->sum('ppnbm');

        $data['cl_1a_jumlah_dpp'] =
           ($data['cl_1a1_dpp'] ?? 0)
         + ($data['cl_1a2_dpp'] ?? 0)
         + ($data['cl_1a3_dpp'] ?? 0)
         + ($data['cl_1a4_dpp'] ?? 0)
         + ($data['cl_1a5_dpp'] ?? 0)
         + ($data['cl_1a6_dpp'] ?? 0)
         + ($data['cl_1a7_dpp'] ?? 0)
         + ($data['cl_1a8_dpp'] ?? 0)
         + ($data['cl_1a9_dpp'] ?? 0);

        $data['cl_1a_jumlah_ppn'] =
           ($data['cl_1a2_ppn'] ?? 0)
         + ($data['cl_1a3_ppn'] ?? 0)
         + ($data['cl_1a5_ppn'] ?? 0)
         + ($data['cl_1a6_ppn'] ?? 0)
         + ($data['cl_1a7_ppn'] ?? 0)
         + ($data['cl_1a8_ppn'] ?? 0)
         + ($data['cl_1a9_ppn'] ?? 0);

         $data['cl_1a_jumlah_ppnbm'] =
           ($data['cl_1a2_ppnbm'] ?? 0)
         + ($data['cl_1a3_ppnbm'] ?? 0)
         + ($data['cl_1a5_ppnbm'] ?? 0)
         + ($data['cl_1a6_ppnbm'] ?? 0)
         + ($data['cl_1a7_ppnbm'] ?? 0)
         + ($data['cl_1a8_ppnbm'] ?? 0)
         + ($data['cl_1a9_ppnbm'] ?? 0);

        $data['cl_1c_dpp'] = $data['cl_1a_jumlah_dpp'] + ($data['cl_1b_dpp'] ?? 0);

        $faktursMasukan = Faktur::where('akun_penerima_id', $data['sistem_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->get();

        $fakturs2b = $faktursMasukan->whereIn('kode_transaksi', [4, 5]);
        $data['cl_2b_dpp']      = $fakturs2b->sum('dpp');
        $data['cl_2b_dpp_lain'] = $fakturs2b->sum('dpp_lain');
        $data['cl_2b_ppn']      = $fakturs2b->sum('ppn');
        $data['cl_2b_ppnbm']    = $fakturs2b->sum('ppnbm');

        $fakturs2c = $faktursMasukan->whereIn('kode_transaksi', [1, 9, 10]);
        $data['cl_2c_dpp']      = $fakturs2c->sum('dpp');
        $data['cl_2c_ppn']      = $fakturs2c->sum('ppn');
        $data['cl_2c_ppnbm']    = $fakturs2c->sum('ppnbm');

        $fakturs2d = $faktursMasukan->whereIn('kode_transaksi', [2, 3]);
        $data['cl_2d_dpp']      = $fakturs2d->sum('dpp');
        $data['cl_2d_dpp_lain'] = $fakturs2d->sum('dpp_lain');
        $data['cl_2d_ppn']      = $fakturs2d->sum('ppn');
        $data['cl_2d_ppnbm']    = $fakturs2d->sum('ppnbm');

         $data['cl_2g_dpp'] =
           ($data['cl_2a_dpp'] ?? 0)
         + ($data['cl_2b_dpp'] ?? 0)
         + ($data['cl_2c_dpp'] ?? 0)
         + ($data['cl_2d_dpp'] ?? 0);

         $data['cl_2g_ppn'] =
            ($data['cl_2a_ppn'] ?? 0)
         + ($data['cl_2b_ppn'] ?? 0)
         + ($data['cl_2c_ppn'] ?? 0)
         + ($data['cl_2d_ppn'] ?? 0);
         + ($data['cl_2e_ppn'] ?? 0);

         $data['cl_2j_dpp'] = ($data['cl_2g_dpp'] ?? 0 ) + ($data['cl_2h_dpp'] ?? 0 ) + ($data['cl_2i_dpp'] ?? 0 );

         $data['cl_3a_ppn'] = ($data['cl_1a2_ppn'] ?? 0) + ($data['cl_1a3_ppn'] ?? 0) + ($data['cl_1a4_ppn'] ?? 0) + ($data['cl_1a5_ppn'] ?? 0);
         $data['cl_3c_ppn'] = ($data['cl_2g_ppn'] ?? 0);
         $data['cl_3e_ppn'] = ($data['cl_3a_ppn'] ?? 0) - ($data['cl_3b_ppn'] ?? 0) - ($data['cl_3c_ppn'] ?? 0) - ($data['cl_3c_ppn'] ?? 0);
         $data['cl_3g_ppn'] = ($data['cl_3e_ppn'] ?? 0) - ($data['cl_3f_ppn'] ?? 0);

         $cl_4_ppn_terutang_dpp = ($data['cl_4_ppn_terutang_dpp'] ?? 0);
         $data['cl_4_ppn_terutang'] = $cl_4_ppn_terutang_dpp * 0.12;

         $data['cl_6a_ppnbm'] = ($data['cl_1a2_ppnbm'] ?? 0) + ($data['cl_1a3_ppnbm'] ?? 0) + ($data['cl_1a4_ppnbm'] ?? 0) + ($data['cl_1a5_ppnbm'] ?? 0);
         $data['cl_6c_ppnbm'] = ($data['cl_6a_ppnbm'] ?? 0) - ($data['cl_6b_ppnbm'] ?? 0);
         $data['cl_6e_ppnbm'] = ($data['cl_6c_ppnbm'] ?? 0) - ($data['cl_6d_ppnbm'] ?? 0);
         $data['cl_6f_diminta_pengembalian'] = $data['cl_6e_ppnbm'] < 0;

         $data['cl_7c_dpp'] = ($data['cl_7a_dpp'] ?? 0) - ($data['cl_7b_dpp'] ?? 0);
         $data['cl_7c_ppn'] = ($data['cl_7a_ppn'] ?? 0) - ($data['cl_7b_ppn'] ?? 0);
         $data['cl_7c_ppnbm'] = ($data['cl_7a_ppnbm'] ?? 0) - ($data['cl_7b_ppnbm'] ?? 0);
         $data['cl_7c_dpp_lain'] = ($data['cl_7a_dpp_lain'] ?? 0) - ($data['cl_7b_dpp_lain'] ?? 0);

         $data['cl_8c_dpp'] = ($data['cl_8a_dpp'] ?? 0) - ($data['cl_8b_dpp'] ?? 0);
         $data['cl_8c_ppn'] = ($data['cl_8a_ppn'] ?? 0) - ($data['cl_8b_ppn'] ?? 0);
         $data['cl_8c_ppnbm'] = ($data['cl_8a_ppnbm'] ?? 0) - ($data['cl_8b_ppnbm'] ?? 0);
         $data['cl_8c_dpp_lain'] = ($data['cl_8a_dpp_lain'] ?? 0) - ($data['cl_8b_dpp_lain'] ?? 0);
        // dd($data);

        $spt_ppns = parent::create($data);

        Faktur::where('pic_id', $data['pic_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->update(['spt_ppns_id' => $spt_ppns->id]);

        Faktur::where('akun_penerima_id', $data['sistem_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->update(['spt_ppns_id' => $spt_ppns->id]);

        return $spt_ppns;
    }

    public function checkPeriode(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->authorizeAccess($assignment, $sistem);

        $picId = $request->query('pic_id');
        $periode = $request->query('periode');
        $pic = Pic::where('id', $picId)->first();
        if (!$pic) {
            abort(404, 'Belum ada PIC');
        }
        $picId = $pic->id;

        $check = SptPpn::where('pic_id', $picId)
                       ->where('periode', $periode)
                       ->first();

        if (empty($check)) {
            return [
                //alur normal
                'periode' => $request->input('periode'),
            ];
        }else {
            if ($check->is_pembetulan == false) {
                return response()->json([
                    'message' => 'Spt Ppn masih draft',
                    'code' => 101,
                ]);
            }else {
                //alur pembetulan
                return [
                    'is_pembetulan' => $check->is_pembetulan,
                    'checkId' => $check->id,
                ];
            }
        }
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
}