<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function availableExams()
    {
        $studentId = 1; // Default student ID
        
        $availableExams = Exam::where('status', 'published')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with('questionSet')
            ->get();

        return view('student.exams.available', compact('availableExams'));
    }

    public function showExam(Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        // Check if student has already taken this exam
        $existingResult = StudentExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->first();

        if ($existingResult && !$exam->allow_retake) {
            return redirect()->route('student.exams.result', $exam)
                ->with('error', 'You have already taken this exam.');
        }

        return view('student.exams.show', compact('exam'));
    }

    public function startExam(Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        // Check if exam is available
        if ($exam->status !== 'published' || now() < $exam->start_time || now() > $exam->end_time) {
            return redirect()->route('student.exams.available')
                ->with('error', 'This exam is not available at this time.');
        }

        // Check if student has already taken this exam
        $existingResult = StudentExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->first();

        if ($existingResult && !$exam->allow_retake) {
            return redirect()->route('student.exams.result', $exam)
                ->with('error', 'You have already completed this exam.');
        }

        // Create or get existing result
        $result = StudentExamResult::firstOrCreate([
            'student_id' => $studentId,
            'exam_id' => $exam->id,
        ], [
            'started_at' => now(),
            'total_questions' => $exam->questionSet->questions()->count(),
            'status' => 'in_progress',
        ]);

        $questions = $exam->questionSet->questions()->orderBy('pivot_order')->get();

        return view('student.exams.take', compact('exam', 'questions', 'result'));
    }

    public function submitExam(Request $request, Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        $result = StudentExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $questions = $exam->questionSet->questions;
        
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;

        foreach ($questions as $question) {
            $studentAnswer = $answers[$question->id] ?? null;
            
            if ($studentAnswer === null) {
                $unanswered++;
            } elseif ($studentAnswer === $question->correct_answer) {
                $correctAnswers++;
            } else {
                $wrongAnswers++;
            }
        }

        $totalMarks = $questions->sum('marks');
        $earnedMarks = $correctAnswers * $questions->first()->marks; // Assuming all questions have same marks
        $percentage = $totalMarks > 0 ? ($earnedMarks / $totalMarks) * 100 : 0;

        $result->update([
            'completed_at' => now(),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'score' => $earnedMarks,
            'percentage' => $percentage,
            'status' => 'completed',
            'answers' => $answers,
        ]);

        return redirect()->route('student.exams.result', $exam)
            ->with('success', 'Exam submitted successfully!');
    }

    public function showResult(Exam $exam)
    {
        $studentId = 1; // Default student ID
        
        $result = StudentExamResult::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->firstOrFail();

        $questions = $exam->questionSet->questions;

        return view('student.exams.result', compact('exam', 'result', 'questions'));
    }

    public function history()
    {
        $studentId = 1; // Default student ID
        
        $results = StudentExamResult::where('student_id', $studentId)
            ->with(['exam.questionSet'])
            ->latest()
            ->paginate(15);

        return view('student.exams.history', compact('results'));
    }
}
