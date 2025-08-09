<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Question;
use App\Models\QuestionSet;
use App\Models\Exam;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class PartnerDashboardController extends Controller
{
    public function index()
    {
        // For now, we'll use a default partner ID (1)
        // In a real application, this would come from authentication
        $partnerId = 1;
        
        $stats = [
            'total_questions' => Question::where('partner_id', $partnerId)->count(),
            'total_question_sets' => QuestionSet::where('partner_id', $partnerId)->count(),
            'total_exams' => Exam::where('partner_id', $partnerId)->count(),
            'total_students' => StudentExamResult::whereHas('exam', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })->distinct('student_id')->count(),
        ];

        $recent_exams = Exam::where('partner_id', $partnerId)
            ->with('questionSet')
            ->latest()
            ->take(5)
            ->get();

        $recent_results = StudentExamResult::whereHas('exam', function($query) use ($partnerId) {
            $query->where('partner_id', $partnerId);
        })
        ->with(['student', 'exam'])
        ->latest()
        ->take(10)
        ->get();

        return view('partner.dashboard', compact('stats', 'recent_exams', 'recent_results'));
    }
}
