<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'logo',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function questionSets()
    {
        return $this->hasMany(QuestionSet::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function studentExamResults()
    {
        return $this->hasManyThrough(StudentExamResult::class, Exam::class);
    }
}
