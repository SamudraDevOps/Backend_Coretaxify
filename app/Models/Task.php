<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
    ];

    protected $guarded = ['id'];

    public function accounts(): HasMany {
        return $this->hasMany(Account::class);
    }

    public function contracts(): HasMany {
        return $this->hasMany(Contract::class);
    }

    // public function lecture_tasks()
    // {
    //     return $this->hasMany(LectureTask::class);
    // }
}
