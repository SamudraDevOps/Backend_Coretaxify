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

    public function sistems()
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
}
