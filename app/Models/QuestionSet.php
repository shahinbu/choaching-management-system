<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'name',
        'description',
        'total_questions',
        'total_marks',
        'time_limit',
        'difficulty_level',
        'randomize_questions',
        'show_results',
        'status',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'total_marks' => 'integer',
        'time_limit' => 'integer',
        'difficulty_level' => 'integer',
        'randomize_questions' => 'boolean',
        'show_results' => 'boolean',
        'status' => 'string',
    ];

    // Relationships
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_set_question')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderBy('pivot_order');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Methods
    public function updateTotals()
    {
        $this->total_questions = $this->questions()->count();
        $this->total_marks = $this->questions()->sum('marks');
        $this->save();
    }

    public function getDifficultyTextAttribute()
    {
        return match($this->difficulty_level) {
            1 => 'Easy',
            2 => 'Medium',
            3 => 'Hard',
            default => 'Mixed'
        };
    }

    public function getFormattedTimeLimitAttribute()
    {
        $hours = floor($this->time_limit / 60);
        $minutes = $this->time_limit % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        return $minutes . 'm';
    }

    public function getShareUrlAttribute()
    {
        return route('partner.question-sets.public', $this->id);
    }

    public function getQuestionsByDifficulty()
    {
        return $this->questions()
            ->selectRaw('difficulty_level, COUNT(*) as count')
            ->groupBy('difficulty_level')
            ->pluck('count', 'difficulty_level')
            ->toArray();
    }

    public function getQuestionsBySubject()
    {
        return $this->questions()
            ->join('topics', 'questions.topic_id', '=', 'topics.id')
            ->join('subjects', 'topics.subject_id', '=', 'subjects.id')
            ->selectRaw('subjects.name, COUNT(*) as count')
            ->groupBy('subjects.name')
            ->pluck('count', 'name')
            ->toArray();
    }
}
