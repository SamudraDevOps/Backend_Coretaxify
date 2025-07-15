<?php

namespace App\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use Illuminate\Support\Facades\Auth;
use App\Support\Interfaces\Services\PembayaranServiceInterface;
use App\Support\Interfaces\Repositories\PembayaranRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class PembayaranService extends BaseCrudService implements PembayaranServiceInterface {
    protected function getRepositoryClass(): string {
        return PembayaranRepositoryInterface::class;
    }

    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Request $request): void
    {
        $user_id = $request->get('user_id');
        $assignmentUser = AssignmentUser::where([
            'user_id' => $user_id ?? auth()->id(),
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

    public function getAllForPembayaran(Sistem $sistem, int $perPage) {
        $pembayarans = Pembayaran::where('badan_id', $sistem->id)
                        ->where('is_paid', false)
                        ->paginate($perPage);

        return $pembayarans;
    }

    public function getAllForSudahPembayaran(Sistem $sistem, int $perPage) {
        $pembayarans = Pembayaran::where('badan_id', $sistem->id)
                        ->where('is_paid', true)
                        ->paginate($perPage);

        return $pembayarans;
    }
}
