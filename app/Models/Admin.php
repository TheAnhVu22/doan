<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $guard = 'admin';

    const ADMIN_ROLE = 1;
    const STAFF_ROLE = 2;

    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar',
        'phone',
        'birthday',
        'is_active',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    // public function isAdmin() { 
    //     return $this->role_id == self::ADMIN_ROLE;
    // }

    // public function isStaff() { 
    //     return $this->role_id == self::STAFF_ROLE;
    // }

    // public function isBlock() { 
    //     return $this->is_active == self::BLOCK_USER;
    // }
}
