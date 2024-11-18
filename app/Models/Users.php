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
    protected $fillable = ['USERNAME', 'EMAIL', 'PASSWORD_HASH', 'ROLE'];

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
}