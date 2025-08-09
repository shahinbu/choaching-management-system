<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // For now, we'll use a default student ID (1)
        // In a real application, this would come from authentication
        $studentId = 1;
        
        $student = Student::find($studentId);
        
        $available_exams = Exam::where('status', 'published')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with('questionSet')
            ->get();

        $recent_results = StudentExamResult::where('student_id', $studentId)
            ->with('exam')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_exams_taken' => StudentExamResult::where('student_id', $studentId)->count(),
            'passed_exams' => StudentExamResult::where('student_id', $studentId)
                ->whereHas('exam', function($query) {
                    $query->whereColumn('passing_marks', '<=', 'student_exam_results.percentage');
                })->count(),
            'average_score' => StudentExamResult::where('student_id', $studentId)->avg('percentage') ?? 0,
        ];

        return view('student.dashboard', compact('student', 'available_exams', 'recent_results', 'stats'));
    }
}
