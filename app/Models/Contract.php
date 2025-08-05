<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Support\Enums\ContractStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contract extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'university_id',
        'task_id',
        'contract_type',
        'qty_student',
        'start_period',
        'end_period',
        'spt',
        'bupot',
        'faktur',
        'contract_code',
        'is_buy_task',
        'status'
    ];

    const TYPE_LICENSE = 'LICENSE';
    const TYPE_UNIT = 'UNIT';
    const TYPE_BNSP = 'BNSP';

    public function isValid() {
        // If status is not ACTIVE, return false immediately
        if ($this->status !== ContractStatusEnum::ACTIVE->value) {
            return false;
        }

        // If status is ACTIVE, then check if the end period is in the future or now
        return $this->start_period >= now() && $this->end_period <= now();
    }

    public static function generateContractCode($type, $existingNumber = null) {
        $prefix = match ($type) {
            self::TYPE_LICENSE => 'L-',
            self::TYPE_UNIT => 'U-',
            self::TYPE_BNSP => 'BNSP-',
        };

        $randomString = strtoupper(Str::random(5));
        return $prefix . $randomString;
    }

    public function university(): BelongsTo {
        return $this->belongsTo(University::class);
    }

    public function users() {
        return $this->hasMany(User::class, 'users');

    }

    public function tasks(): BelongsToMany {
        return $this->belongsToMany(Task::class, 'contract_tasks');
    }
}
