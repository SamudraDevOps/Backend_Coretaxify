<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'university_id',
        'contract_type',
        'qty_student',
        'start_period',
        'end_period',
        'spt',
        'bupot',
        'faktur',
        'contract_code',
    ];

    const TYPE_LICENSE = 'LICENSE';
    const TYPE_UNIT = 'UNIT';
    const TYPE_BNSP = 'BNSP';

    public static function generateContractCode($type, $existingNumber = null) {
        $prefix = match ($type) {
            self::TYPE_LICENSE => 'L-',
            self::TYPE_UNIT => 'U-',
            self::TYPE_BNSP => 'BNSP-',
        };

        if($existingNumber) {
            $number = $existingNumber;
        } else {
            $lastContract = self::orderBy('id', 'desc')->first();
            $number = $lastContract ? (intval(substr($lastContract->contract_code, strrpos($lastContract->contract_code, '-') + 1)) + 1) : 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function university(): BelongsTo {
        return $this->belongsTo(University::class);
    }

    public function users() {
        return $this->hasMany(User::class, 'users');

    }
}
