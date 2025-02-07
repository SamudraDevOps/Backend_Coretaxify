<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaskUser extends Model
{
    /** @use HasFactory<\Database\Factories\TaskUserFactory> */
    use HasFactory;
    
    protected $guarded = ['id'];
}