<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'country',   // ← ДОБАВЬ ЭТО
        'city',      // ← ДОБАВЬ ЭТО
        'phone',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasPermission($resource, $action = null)
    {
        if (!$this->role) {
            return false;
        }

        if ($this->isSuperAdmin()) {
            return true;
        }
        
        return $this->role->hasPermission($resource, $action);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role
            && is_array($this->role->permissions)
            && in_array('*', $this->role->permissions, true);
    }
}
