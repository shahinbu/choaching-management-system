<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'question_set_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'duration',
        'passing_marks',
        'status',
        'allow_retake',
        'show_results_immediately',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'integer',
        'passing_marks' => 'integer',
        'status' => 'string',
        'allow_retake' => 'boolean',
        'show_results_immediately' => 'boolean',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function questionSet()
    {
        return $this->belongsTo(QuestionSet::class);
    }

    public function studentResults()
    {
        return $this->hasMany(StudentExamResult::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_exam_results');
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        $now = now();
        return $this->status === 'published' && 
               $now->gte($this->start_time) && 
               $now->lte($this->end_time);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->status === 'published' && now()->lt($this->start_time);
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed' || now()->gt($this->end_time);
    }
}
