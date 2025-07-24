<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'user_id',
        'class_code',
        'status',
    ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'group_users');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Many to Many
    // public function assignments(): BelongsToMany {
    //     return $this->belongsToMany(Assignment::class, 'group_assignments');
    // }

    // 1 Praktikum 1 Kelas
    public function assignments(): HasMany {
        return $this->hasMany(Assignment::class);
    }

    // public static function generateClassCode($existingNumber = null) {
    //     $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    //     if($existingNumber) {
    //         $number = $existingNumber;
    //     } else {
    //         do {
    //             $code = '';
    //             for ($i = 0; $i < 4; $i++) {
    //                 $code .= $characters[rand(0, strlen($characters) - 1)];
    //             }

    //             $exists = self::where('class_code', $code)->exists();
    //         } while ($exists);

    //         $number = $code;
    //     }

    //     return str_pad($number, 4, '0', STR_PAD_LEFT);
    // }
}
