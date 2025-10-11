<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'department', 'location', 'job_type',
        'description', 'requirements', 'responsibilities',
        'salary_range', 'deadline', 'status'
    ];

    public function applications()
    {
        return $this->hasMany(CareerApplication::class);
    }
}
