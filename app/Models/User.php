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

    //RBAC IMPLEMENTATION FUNCTIONS
    // function to assign roles
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission($permission)
    {
        return $this->roles()
            ->with('permissions')
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }

}