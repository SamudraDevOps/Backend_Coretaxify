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

    public function isValid() {
        if ($this->assignment->isExam()) {
            return $this->remainingTime() > 0;
        }

        return $this->assignment->start_period <= now() && $this->assignment->end_period >= now();
    }

    public function remainingTime() {
        if (!$this->assignment->isExam()) {
            return null;
        }

        $endPeriod = $this->assignment->end_period;
        $personalDeadline = $this->started_at->addMinutes($this->assignment->duration);

        $finalDeadline = $endPeriod->lt($personalDeadline) ? $endPeriod : $personalDeadline;

        return now()->lt($finalDeadline) ? now()->diffInSeconds() : 0;
    }

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
