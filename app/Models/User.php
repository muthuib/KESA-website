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
        'FIRST_NAME',
        'MIDDLE_NAME',
        'LAST_NAME',
        'EMAIL',
        'EMAIL_VERIFICATION',
        'email_verified_at',
        'PASSWORD_HASH',
        'ROLE',
        'GENDER',
        'PHONE_NUMBER',
        'ALTERNATIVE_PHONE_NUMBER',
        'NATIONAL_ID_NUMBER',
        'DISABILITY_STATUS',
        'DISABILITY_TYPE',
        'PASSPORT_PHOTO',
        'CURRENTLY_IN_SCHOOL',
        'HIGHEST_LEVEL_SCHOOL_ATTENDING',
        'SCHOOL_NAME',
        'PROGRAM_OF_STUDY',
        'SCHOOL_REGISTRATION_NUMBER',
        'HIGHEST_LEVEL_SCHOOL_ATTENDED',
        'EDUCATION_LEVEL',
        'PREVIOUS_SCHOOL_NAME',
        'PREVIOUS_PROGRAM_OF_STUDY',
        'REGISTRATION_FEE',
        'MEMBERSHIP_NUMBER',

        // New fields added
        'TITTLE',
        'POSTAL_ADDRESS',
        'PHYSICAL_ADDRESS',
        'COUNTY',
        'LINKEDIN',
        'PROFESSION',
        'WORK_PLACE',
        'JOB',
        'COMMENT',
        'DATE',
        'type',
        'must_change_password',
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

    // Email verification method
    public function markEmailAsVerified()
    {
        $this->EMAIL_VERIFICATION = 1; // Set email verification status to true (1)
        $this->email_verified_at = now();
        $this->save();
    }

    public function hasVerifiedEmail()
    {
        return $this->EMAIL_VERIFICATION === 1; // Check if email is verified
    }

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
}
