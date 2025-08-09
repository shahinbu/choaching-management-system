<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_id',
        'started_at',
        'completed_at',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'unanswered',
        'score',
        'percentage',
        'status',
        'answers',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'wrong_answers' => 'integer',
        'unanswered' => 'integer',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'status' => 'string',
        'answers' => 'array',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Accessors
    public function getIsPassedAttribute()
    {
        return $this->percentage >= $this->exam->passing_marks;
    }

    public function getTimeTakenAttribute()
    {
        if ($this->completed_at && $this->started_at) {
            return $this->completed_at->diffInMinutes($this->started_at);
        }
        return null;
    }

    public function getGradeAttribute()
    {
        return match(true) {
            $this->percentage >= 90 => 'A+',
            $this->percentage >= 80 => 'A',
            $this->percentage >= 70 => 'B',
            $this->percentage >= 60 => 'C',
            $this->percentage >= 50 => 'D',
            default => 'F'
        };
    }
}
