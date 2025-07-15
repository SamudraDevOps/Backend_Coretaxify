<?php

namespace App\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use App\Support\Interfaces\Services\DetailTransaksiServiceInterface;
use App\Support\Interfaces\Repositories\DetailTransaksiRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class DetailTransaksiService extends BaseCrudService implements DetailTransaksiServiceInterface {
    protected function getRepositoryClass(): string {
        return DetailTransaksiRepositoryInterface::class;
    }

    public function authorizeAccess(Assignment $assignment, Sistem $sistem, Faktur $faktur, Request $request): void
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

        if ($faktur->akun_pengirim_id !== $sistem->id) {
            abort(403, 'Unauthorized access to this faktur');
        }
    }

    public function authorizeDetailTraBelongsToFaktur(Faktur $faktur, DetailTransaksi $detailTransaksi, Request $request): void
    {
        $user_id = $request->get('user_id');
        if (($faktur->id !== $detailTransaksi->faktur_id) && !$user_id) {
            abort(403, 'Unauthorized access to this faktur');
        }
    }
}
