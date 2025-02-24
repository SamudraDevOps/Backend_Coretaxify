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
        'user_id',
        'name',
        'file_path',
    ];
    protected $guarded = ['id'];

    public function accounts(): HasMany {
        return $this->hasMany(Account::class);
    }

    public function contracts(): BelongsToMany {
        return $this->belongsToMany(Contract::class, 'contract_tasks');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // public function assignments()
    // {
    //     return $this->hasMany(Assignment::class);
    // }
}
