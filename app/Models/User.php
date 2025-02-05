<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image_path',
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

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role) {
        return $this->roles->contains('name', $role);
    }

    public function groups(): BelongsToMany {
        return $this->belongsToMany(Group::class, 'group_users');

    }

    public function contract()
    {
        return $this->hasMany(Contract::class, 'contracts');
    }

    public function lecture_task()
    {
        return $this->hasMany(LectureTask::class, 'lecture_tasks');
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'task_users');
    }
}