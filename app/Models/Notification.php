<?php
namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends DatabaseNotification
{
    use HasFactory;

    // Define the table name
    protected $table = 'notifications';

    // Define fillable attributes
    protected $fillable = [
        'USER_ID',
        'TITLE',
        'MESSAGE',
        'READ_AT',
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
    // Define the relation if necessary
    public function notifiable()
    {
        return $this->morphTo(); // Assumes polymorphic relationship
    }
}

