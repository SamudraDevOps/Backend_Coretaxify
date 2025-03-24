<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class TaskResource extends JsonResource {
    public function toArray($request): array {
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'name' => $this->name,
            'file_path' => $this->file_path,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];

        if (!empty($this->file_path)) {
            $prefix = $this->getUserRolePrefix();
            $data['file_path_url'] = URL::temporarySignedRoute(
                'download.task.file',
                now()->addMinutes(30), // Short expiration time
                ['task' => $this->id]
            );
        } else {
            $data['file_path_url'] = null;
        }

        return $data;
    }

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
        return 'admin';

    }
}
