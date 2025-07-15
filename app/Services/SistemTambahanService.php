<?php

namespace App\Services;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Support\Interfaces\Services\SistemTambahanServiceInterface;
use App\Support\Interfaces\Repositories\SistemTambahanRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SistemTambahanService extends BaseCrudService implements SistemTambahanServiceInterface {
    protected function getRepositoryClass(): string {
        return SistemTambahanRepositoryInterface::class;
    }

    // public function create(array $data, Sistem $sistem = null): ?Model {
    //     $data['assignment_user_id'] = $sistem->assignment_user->id;

    //     return $this->repository->create($data);
    // }

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

    public function authorizeFakturBelongsToSistem(Faktur $faktur, Sistem $sistem, Request $request): void
    {
        $user_id = $request->get('user_id');
        if (($faktur->akun_pengirim !== $sistem->id) && !$user_id) {
            abort(403, 'Unauthorized access to this faktur');
        }
    }
}
