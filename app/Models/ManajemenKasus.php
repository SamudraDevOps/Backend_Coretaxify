<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManajemenKasus extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'kanal',
        'tanggal_permohonan',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function assignment_users()
    {
        return $this->hasMany(AssignmentUser::class);
    }

}