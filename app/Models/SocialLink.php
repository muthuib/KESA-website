<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'platform', 'url'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
