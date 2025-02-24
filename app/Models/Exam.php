<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'task_id',
        'name',
        'exam_code',
        'start_period',
        'end_period',
        'duration',
        // 'filename',
        'supporting_file',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'exam_users');
    }

    // public function accounts(): HasMany {
    //     return $this->hasMany(Account::class);
    // }

    public function task(): HasOne {
        return $this->hasOne(Task::class);
    }
}
