<?php

namespace App\Http\Resources;

use App\Support\Enums\ContractStatusEnum;
use Illuminate\Support\Carbon;
use App\Support\Enums\IntentEnum;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource {
    public function toArray($request): array {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'assignment_code' => $this->assignment_code,
            'group_id' => $this->group_id,
            'instansi' => $this->user->contract ? $this->user->contract->university->name : null,
            'group' => new GroupResource($this->group),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'users_count' => count($this->users),
            'supporting_file' => $this->supporting_file,
            'task_id' => $this->task_id,
            'task' => new TaskResource($this->task),
            'start_period' => $this->start_period ? Carbon::parse($this->start_period)->format('d-m-Y H:i:s') : null,
            'end_period' => $this->end_period ? Carbon::parse($this->end_period)->format('d-m-Y H:i:s') : null,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];

        // Add download URL for supporting file if it exists
        if (!empty($this->supporting_file)) {
            $prefix = $this->getUserRolePrefix();
            $data['supporting_file_url'] = URL::temporarySignedRoute(
                'download.assignment.file',
                now()->addMinutes(30), // Short expiration time
                ['assignment' => $this->id]
            );
        } else {
            $data['supporting_file_url'] = null;
        }

        if(!empty($this->duration)) {
            $data['duration'] = $this->duration;
        }

        $user = $this->user;

        if ($user->hasAnyRole(['admin', 'psc', 'instruktur', 'mahasiswa-psc'])) {
            $data['valid'] = true;
        } else if (!empty($this->user->contract->end_period)) {
            $user->contract->status == ContractStatusEnum::INACTIVE->value ? $data['valid'] = false : $data['valid'] = Carbon::parse($this->end_period)->greaterThan(now());
        } else {
            $data['valid'] = true;
        }

        return $data;
    }

    /**
     * Determine the appropriate prefix based on user role
     */
    protected function getUserRolePrefix(): string {
        $user = auth()->user();

        if ($user->hasRole('dosen')) {
            return 'lecturer';
        } else if ($user->hasRole('mahasiswa')) {
            return 'student';
        } else if ($user->hasRole('psc')) {
            return 'psc';
        } else if ($user->hasRole('mahasiswa-psc')) {
            return 'student-psc';
        } else if ($user->hasRole('instruktur')) {
            return 'instructor';
        } else if ($user->hasRole('admin')) {
            return 'admin';
        }

        // Default fallback - could also throw an exception if preferred
        return 'student';

    }
}
