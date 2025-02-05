<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $guarded = ['id'];

    public function group_user()
    {
        return $this->hasMany(GroupUser::class, 'group_users');
    }

    public function lecture_task()
    {
        return $this->hasMany(LectureTask::class, 'lecture_tasks');
    }
}