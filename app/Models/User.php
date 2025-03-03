<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'email_otp',
        'email_otp_expires_at',
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
            'email_otp_expires_at' => 'datetime',
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

    public function group() {
        return $this->hasMany(Group::class);
    }

    public function hasGroup($groupName) {
        return $this->groups->contains('name', $groupName);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function assignments(): BelongsToMany {
        return $this->belongsToMany(Assignment::class, 'assignment_users');
    }

    public function assignment() {
        return $this->hasMany(Assignment::class);
    }

    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }

    public function exams(): BelongsToMany {
        return $this->belongsToMany(Exam::class, 'exam_users');
    }

    public function exam(): HasMany {
        return $this->HasMany(Exam::class);
    }

    public function generateOtp()
    {
        $this->email_otp = rand(1000, 9999); // Generate 4-digit OTP
        $this->email_otp_expires_at = now()->addMinutes(10); // OTP expires in 10 minutes
        $this->save();
    }
}
