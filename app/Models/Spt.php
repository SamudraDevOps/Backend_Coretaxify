<?php

namespace App\Models;

use App\Models\Sistem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spt extends Model
{
    protected $guarded = ['id'];

    public function pic()
    {
        return $this->belongsTo(Pic::class);
    }

    public function spt_ppn()
    {
        return $this->hasOne(SptPpn::class);
    }

    public function sistem(): BelongsTo
    {
        return $this->belongsTo(Sistem::class);
    }
}
