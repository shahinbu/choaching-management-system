<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'student_id',
        'date_of_birth',
        'gender',
        'photo',
        'email',
        'phone',
        'address',
        'city',
        'school_college',
        'class_grade',
        'parent_name',
        'parent_phone',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => 'string',
    ];

    // Relationships
    public function examResults()
    {
        return $this->hasMany(StudentExamResult::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'student_exam_results');
    }
}
