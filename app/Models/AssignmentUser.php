<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AssignmentUser extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentUserFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function sistems()
    {
        return $this->hasMany(Sistem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    public function assignment(): BelongsTo {
        return $this->belongsTo(Assignment::class);
    }
}