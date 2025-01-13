<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['organization_name', 'email', 'phone', 'address'];

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function additionalContacts()
    {
        return $this->hasMany(AdditionalContact::class);
    }
}
