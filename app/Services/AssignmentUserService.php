<?php

namespace App\Services;

use App\Support\Interfaces\Services\AssignmentUserServiceInterface;
use App\Support\Interfaces\Repositories\AssignmentUserRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Pic;

class AssignmentUserService extends BaseCrudService implements AssignmentUserServiceInterface {
    protected function getRepositoryClass(): string {
        return AssignmentUserRepositoryInterface::class;
    }

    public function getAssignmentUserByUserId($userId, $perPage = 15) {
        $repository = app($this->getRepositoryClass());
        $user = auth()->user();

        if($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc' || $user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('instruktur') || $user->hasRole('admin'))) {
            return $repository->query()->whereHas('user', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate($perPage);
        }
    }

    public function getPic($assignmentUser) {
        // dd($assignmentUser);
        $data = Pic::where('assignment_user_id', $assignmentUser->id)->get();
        return $data;
    }
}
