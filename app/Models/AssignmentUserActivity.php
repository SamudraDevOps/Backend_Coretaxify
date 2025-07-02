<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentUserActivity extends Model
{
    protected $fillable = [
        'assignment_user_id',
        'user_id',
        'activity_type',
        'description',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function assignmentUser(): BelongsTo
    {
        return $this->belongsTo(AssignmentUser::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
