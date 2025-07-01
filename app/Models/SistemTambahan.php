<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistemTambahan extends Model
{
    protected $guarded = ['id'];

    public function assignment_user(){
        return $this->belongsTo(AssignmentUser::class);
    }
}
