<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'activities';

    // Define fillable attributes
    protected $fillable = [
        'USER_ID',
        'ACTION',
        'DESCRIPTION',
    ];
    // If your table uses custom primary key name (still 'id' in this case, so optional)
    //since our columns are in uppercase we will define this key to move it from default laravel snake case id.
    protected $primaryKey = 'ID';

    // Specify that your table uses timestamps (created_at and updated_at)
    public $timestamps = true;
    
    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

