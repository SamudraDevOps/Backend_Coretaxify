<?php

namespace App\Models;

use App\Models\Faktur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function faktur(): BelongsTo {
        return $this->belongsTo(Faktur::class);
    }
}
