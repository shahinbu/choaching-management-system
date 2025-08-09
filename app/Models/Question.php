<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'partner_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'difficulty_level',
        'marks',
        'image',
        'status',
    ];

    protected $casts = [
        'difficulty_level' => 'integer',
        'marks' => 'integer',
        'status' => 'string',
    ];

    // Relationships
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function questionSets()
    {
        return $this->belongsToMany(QuestionSet::class, 'question_set_question')
                    ->withPivot('order')
                    ->withTimestamps();
    }

    public function subject()
    {
        return $this->belongsToThrough(Subject::class, Topic::class);
    }

    public function course()
    {
        return $this->belongsToThrough(Course::class, [Subject::class, Topic::class]);
    }

    // Accessors
    public function getCorrectOptionTextAttribute()
    {
        return $this->{'option_' . $this->correct_answer};
    }

    public function getDifficultyTextAttribute()
    {
        return match($this->difficulty_level) {
            1 => 'Easy',
            2 => 'Medium',
            3 => 'Hard',
            default => 'Unknown'
        };
    }
}
