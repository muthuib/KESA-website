<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about'; // Table name in lowercase

    protected $fillable = [
        'VISION',
        'MISSION',
        'OBJECTIVES'
    ];
     // If your table uses custom primary key name (still 'id' in this case, so optional)
    //since our columns are in uppercase we will define this key to move it from default laravel snake case id.
    protected $primaryKey = 'ID';

    // Specify that your table uses timestamps (created_at and updated_at)
    public $timestamps = true;
}
