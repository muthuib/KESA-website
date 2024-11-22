<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    // If the table name is also in uppercase
    protected $table = 'resources';  // No need to specify unless it differs from default

    // Specify the fillable attributes (with uppercase column names)
    protected $fillable = ['TITLE', 'DESCRIPTION', 'FILE_PATH', 'PRICE'];

    // If your table uses custom primary key name (still 'id' in this case, so optional)
    //since our columns are in uppercase we will define this key to move it from default laravel snake case id.
     protected $primaryKey = 'ID';

    // Specify that your table uses timestamps (created_at and updated_at)
    public $timestamps = true;

    // Optionally, if your columns are in a different format, you can use this:
    // protected $keyType = 'string'; // Uncomment if primary key is a string
}