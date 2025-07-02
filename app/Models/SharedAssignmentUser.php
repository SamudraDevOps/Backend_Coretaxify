<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SharedAssignmentUser extends Model
{
    protected $fillable = [
        'original_assignment_user_id',
        'shared_assignment_user_id',
        'shared_by_user_id',
        'shared_to_user_id',
        'share_type',
        'shared_at',
        'metadata'
    ];

    protected $casts = [
        'shared_at' => 'datetime',
        'metadata' => 'array'
    ];

    public function originalAssignmentUser(): BelongsTo
    {
        return $this->belongsTo(AssignmentUser::class, 'original_assignment_user_id');
    }

    public function sharedAssignmentUser(): BelongsTo
    {
        return $this->belongsTo(AssignmentUser::class, 'shared_assignment_user_id');
    }

    public function sharedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shared_by_user_id');
    }

    public function sharedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shared_to_user_id');
    }
}
