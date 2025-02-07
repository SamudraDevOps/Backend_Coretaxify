<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $guarded = ['id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lecture_tasks(): BelongsToMany {
        return $this->belongsToMany(LectureTask::class, 'task_users');
    }

    public static function generateClassCode($existingNumber = null) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
        if($existingNumber) {
            $number = $existingNumber;
        } else {
            do {
                $code = '';
                for ($i = 0; $i < 4; $i++) {
                    $code .= $characters[rand(0, strlen($characters) - 1)];
                }
                
                $exists = self::where('class_code', $code)->exists();
            } while ($exists);
            
            $number = $code;
        }

        return str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}