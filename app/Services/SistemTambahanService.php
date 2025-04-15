<?php

namespace App\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use Illuminate\Support\Facades\Auth;
use App\Support\Interfaces\Services\SistemTambahanServiceInterface;
use App\Support\Interfaces\Repositories\SistemTambahanRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SistemTambahanService extends BaseCrudService implements SistemTambahanServiceInterface {
    protected function getRepositoryClass(): string {
        return SistemTambahanRepositoryInterface::class;
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
        if ($faktur->akun_pengirim !== $sistem->id) {
            abort(403, 'Unauthorized access to this faktur');
        }
    }
}
