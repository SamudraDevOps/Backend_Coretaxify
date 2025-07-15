<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfAssignment extends Model
{
    /** @use HasFactory<\Database\Factories\SelfAssignmentFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'task_id',
        'name',
        'supporting_file',
        'is_start',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
