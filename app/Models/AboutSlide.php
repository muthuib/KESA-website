<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSlide extends Model
{
    use HasFactory;

    // Optionally, specify the table name if it's not the plural form of the model
    protected $table = 'about_slides';

    // Specify fillable fields if using mass assignment
    protected $fillable = ['IMAGE_PATH', 'CAPTION'];

    // Specify that your table uses timestamps (created_at and updated_at)
    public $timestamps = true;
}
