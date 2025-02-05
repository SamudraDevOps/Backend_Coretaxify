<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoleUser extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsToMany {
        return $this->belongsToMany(User::class, 'users');
    }

    public function role(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'roles');
    }
}