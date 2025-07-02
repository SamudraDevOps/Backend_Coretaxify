<?php

namespace App\Models;

use App\Models\Pic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssignmentUser extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentUserFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'shared_metadata' => 'array'
    ];

    public function sistems(): HasMany
    {
        return $this->hasMany(Sistem::class);
    }

    public function pics(): HasMany {
        return $this->hasMany(Pic::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function assignment(): BelongsTo {
        return $this->belongsTo(Assignment::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(AssignmentUserActivity::class);
    }

    public function originalAssignmentUser(): BelongsTo
    {
        return $this->belongsTo(AssignmentUser::class, 'original_assignment_user_id');
    }

    public function sharedCopies(): HasMany
    {
        return $this->hasMany(AssignmentUser::class, 'original_assignment_user_id');
    }

    public function sharedAssignments(): HasMany
    {
        return $this->hasMany(SharedAssignmentUser::class, 'original_assignment_user_id');
    }

    public function receivedShares(): HasMany
    {
        return $this->hasMany(SharedAssignmentUser::class, 'shared_assignment_user_id');
    }

    public function logActivity(string $activityType, string $description, array $data = []): AssignmentUserActivity
    {
        return $this->activities()->create([
            'user_id' => auth()->id(),
            'activity_type' => $activityType,
            'description' => $description,
            'data' => $data
        ]);
    }

    public function canBeViewedBy(User $user): bool
    {
        // User can view their own assignment
        if ($this->user_id === $user->id) {
            return true;
        }

        // Dosen can view mahasiswa in their groups
        if ($user->hasRole('dosen') && $this->user->hasRole('mahasiswa')) {
            return $this->assignment->group &&
                   $this->assignment->group->user_id === $user->id;
        }

        // PSC can view mahasiswa-psc in their groups
        if ($user->hasRole('psc') && $this->user->hasRole('mahasiswa-psc')) {
            return $this->assignment->group &&
                   $this->assignment->group->user_id === $user->id;
        }

        // Admin can view all
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    public function isSharedCopy(): bool
    {
        return $this->is_shared_copy;
    }

    public function getShareMetadata(): ?array
    {
        return $this->shared_metadata;
    }
}
