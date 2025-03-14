<?php

namespace App\Services;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Support\Interfaces\Services\InformasiUmumServiceInterface;
use App\Support\Interfaces\Repositories\InformasiUmumRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use Illuminate\Database\Eloquent\Model;

class InformasiUmumService extends BaseCrudService implements InformasiUmumServiceInterface {
    protected function getRepositoryClass(): string {
        return InformasiUmumRepositoryInterface::class;
    }

    public function update($keyOrModel = null, array $data, ?Assignment $assignment = null, ?Sistem $sistem = null ): ?Model{

        $assignment = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignment->id) {
            abort(403);
        }

        $sistems = Sistem::where('assignment_user_id', $assignment->id)
                           ->where('id', $sistem->id)
                           ->firstOrFail();

        if ($sistems->assignment_user_id !== $assignment->id) {
            abort(403);
        }

        return $assignment;
    }
}