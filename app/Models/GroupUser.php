<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GroupUser extends Model
{
    public $guarded = ['id'];

    public function user(): BelongsToMany {
        return $this->belongsToMany(User::class, 'users');
    }

    public function group(): BelongsToMany {
        return $this->belongsToMany(Group::class, 'groups');
    }
}