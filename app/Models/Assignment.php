<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assignment extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'assignment_code',
        'start_period',
        'end_period',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'assignment_users');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'assignment_users');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // public function task()
    // {
    //     return $this->belongsTo(Task::class);
    // }

    // public static function generateTaskCode($existingNumber = null) {
    //     $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    //     if($existingNumber) {
    //         $number = $existingNumber;
    //     } else {
    //         do {
    //             $code = '';
    //             for ($i = 0; $i < 5; $i++) {
    //                 $code .= $characters[rand(0, strlen($characters) - 1)];
    //             }

    //             $exists = self::where('task_code', $code)->exists();
    //         } while ($exists);

    //         $number = $code;
    //     }

    //     return str_pad($number, 5, '0', STR_PAD_LEFT);
    // }
}
