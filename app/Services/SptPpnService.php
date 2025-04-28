<?php

namespace App\Services;

use App\Models\Pic;
use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\SptPpn;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Support\Enums\FakturStatusEnum;
use App\Support\Interfaces\Services\SptPpnServiceInterface;
use App\Support\Interfaces\Repositories\SptPpnRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SptPpnService extends BaseCrudService implements SptPpnServiceInterface {
    protected function getRepositoryClass(): string {
        return SptPpnRepositoryInterface::class;
    }

    public function create(array $data): Model {
        //alur normal
        $periode = $data['periode'];

        [$month, $year] = explode(' ', $periode, 2);

        $fakturs = Faktur::where('pic_id', $data['pic_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->get();

        $fakturs1a2 = $fakturs->whereIn('kode_transaksi', [4, 5]);
        $data['kolom_1a2_dpp']      = $fakturs1a2->sum('dpp');
        $data['kolom_1a2_dpp_lain'] = $fakturs1a2->sum('dpp_lain');
        $data['kolom_1a2_ppn']      = $fakturs1a2->sum('ppn');
        $data['kolom_1a2_ppnbm']    = $fakturs1a2->sum('ppnbm');

        $fakturs1a3 = $fakturs->where('kode_transaksi', 6);
        $data['kolom_1a3_dpp']      = $fakturs1a3->sum('dpp');
        $data['kolom_1a3_dpp_lain'] = $fakturs1a3->sum('dpp_lain');
        $data['kolom_1a3_ppn']      = $fakturs1a3->sum('ppn');
        $data['kolom_1a3_ppnbm']    = $fakturs1a3->sum('ppnbm');

        return parent::create($data);
    }

    public function checkPeriode(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->authorizeAccess($assignment, $sistem);

        $picId = $request->query('pic_id');

        $pic = Pic::where('id', $picId)->firstOrFail();
        $picId = $pic->id;

        $periode = $request->query('periode');

        $check = SptPpn::where('pic_id', $picId)
                       ->where('periode', $periode)
                       ->first();

        if (empty($check)) {
            return [
                //alur normal
                'is_pembetulan' => 0,
                'periode' => $request->input('periode'),
            ];
        }else {
            if ($check->is_pembetulan == false) {
                return response()->json([
                    'message' => 'Spt Ppn masih draft',
                    'code' => 403,
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
