<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = ['IMAGE_PATH', 'CAPTION'];

    protected $primaryKey = 'ID';
    // Specify that your table uses timestamps (created_at and updated_at)
    public $timestamps = true;
}
