<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executive extends Model
{
    use HasFactory;
    protected $table = 'executives';

    protected $fillable = ['name', 'designation', 'bio', 'cv_link', 'image'];
}
