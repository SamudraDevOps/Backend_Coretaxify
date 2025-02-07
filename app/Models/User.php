<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'default_password',
        'image_path',
        'contract_id',
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

    public function hasRole($roleName) {
        return $this->roles->contains('name', $roleName);
    }

    public function groups(): BelongsToMany {
        return $this->belongsToMany(Group::class, 'group_users');
    }

    public function hasGroup($groupName) {
        return $this->groups->contains('name', $groupName);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contracts');
    }

    public function lecture_tasks(): BelongsToMany {
        return $this->belongsToMany(LectureTask::class, 'task_users');
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'task_users');
    }
}
=======
}
>>>>>>> origin/isal
