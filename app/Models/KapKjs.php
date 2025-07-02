<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KapKjs extends Model
{
    protected $guarded = ['id'];

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}
