<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role_user(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function group_user(){
        return $this->hasMany(GroupUser::class, 'group_users');
    
    }
    
    public function contract()
    {
        return $this->hasMany(Contract::class, 'contracts');
    }

    public function lecture_task()
    {
        return $this->hasMany(LectureTask::class, 'lecture_tasks');
    }

    public function task_user()
    {
        return $this->hasMany(TaskUser::class, 'task_users');
    }
}