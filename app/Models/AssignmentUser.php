<?php

namespace App\Models;

use App\Models\Pic;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AssignmentUser extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentUserFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function isValid() {
        if ($this->assignment->isExam()) {
            if (!$this->is_start) {
                return $this->assignment->start_period <= now() && $this->assignment->end_period >= now();
            } else {
                return $this->remainingTime() > 0;
            }
        }

        if (!$this->assignment->start_period && !$this->assignment->end_period) {
            if ($this->user->hasRole('dosen')) {
                return $this->user->contract->isValid();
            }

            return true;
        }

        return $this->assignment->start_period <= now() && $this->assignment->end_period >= now();
    }

    public function remainingTime() {
        if (!$this->assignment->isExam()) {
            return null;
        }

        $endPeriod = Carbon::parse($this->assignment->end_period);
        $personalDeadline = Carbon::parse($this->submitted_at);

        $finalDeadline = $endPeriod->lt($personalDeadline) ? $endPeriod : $personalDeadline;

        return now()->lt($finalDeadline) ? now()->diffInSeconds($finalDeadline) : 0;
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
