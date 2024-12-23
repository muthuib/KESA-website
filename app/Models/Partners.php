<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\AuthenticatesPartners;

class Partners extends Authenticatable
{
    use Notifiable, AuthenticatesPartners;

    // Custom table name and primary key
    protected $table = 'partners';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Table columns
    protected $fillable = ['COMPANY_NAME', 'REGISTRATION_NUMBER', 'EMAIL', 'PHONE_NUMBER', 'PHYSICAL_ADDRESS', 'COMPANY_TYPE', 'PASSWORD', 'REASON'];
    

    // Override default password attribute to match `PASSWORD_HASH` column
    public function setPasswordAttribute($password)
    {
        $this->attributes['PASSWORD'] = bcrypt($password);
    }

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

}