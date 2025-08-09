<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Subject::class, 'course_id', 'topic_id');
    }
}
