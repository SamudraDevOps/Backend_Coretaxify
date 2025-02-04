<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contract extends Model
{
    protected $guarded = ['id'];

    public function universities()
    {
        return $this->belongsTo(University::class);
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'users');
    
    }

    
}