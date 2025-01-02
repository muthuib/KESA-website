<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Custom table name and primary key
    protected $table = 'users';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Table columns
    protected $fillable = [
        'USERNAME',
        'FIRST_NAME',
        'LAST_NAME',
        'EMAIL',
        'CATEGORY',
        'COURSE',
        'UNIVERSITY',
        'REASON',
        'PASSWORD_HASH',
        'EMAIL_VERIFICATION',
    ];

    // Override default password attribute to match `PASSWORD_HASH` column
    public function setPasswordAttribute($password)
    {
        $this->attributes['PASSWORD_HASH'] = bcrypt($password);
    }

    public function getAuthPassword()
    {
        return $this->PASSWORD_HASH;
    }

    // Timestamp columns
    const CREATED_AT = 'CREATED_AT';
    const UPDATED_AT = 'UPDATED_AT';

    // RBAC: Check if user has a specific role
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    // Define roles relationship
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    

    // Check if user has a specific permission
    public function hasPermission($permission)
    {
        return $this->roles()
            ->with('permissions')
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }

    // Email verification method
    public function markEmailAsVerified()
    {
        $this->EMAIL_VERIFICATION = 1; // Set email verification status to true (1)
        $this->save();
    }

    public function hasVerifiedEmail()
    {
        return $this->EMAIL_VERIFICATION === 1; // Check if email is verified
    }
}
