<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LectureTask extends Model
{
    /** @use HasFactory<\Database\Factories\LectureTaskFactory> */
    use HasFactory;

    public $guarded = ['id'];

    public function task_user()
    {
        return $this->hasMany(TaskUser::class, 'task_users');
    }

    public function task(): BelongsToMany {
        return $this->belongsToMany(Task::class, 'tasks');
    }

    public function user(): BelongsToMany {
        return $this->belongsToMany(User::class, 'users');
    }

    public function group(): BelongsToMany {
        return $this->belongsToMany(Group::class, 'groups');
    }
}