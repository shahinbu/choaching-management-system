<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\QuestionSet;
use App\Models\StudentExamResult;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['questionSet', 'partner'])
            ->where('partner_id', 1) // Default partner ID
            ->latest()
            ->paginate(15);
        return view('partner.exams.index', compact('exams'));
    }

    public function create()
    {
        $questionSets = QuestionSet::where('partner_id', 1)
            ->where('status', 'published')
            ->get();
        return view('partner.exams.create', compact('questionSets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_set_id' => 'required|exists:question_sets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
        ]);

        $data = $request->all();
        $data['partner_id'] = 1; // Default partner ID
        $data['allow_retake'] = $request->has('allow_retake');
        $data['show_results_immediately'] = $request->has('show_results_immediately');

        Exam::create($data);

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['questionSet.questions', 'studentResults.student']);
        return view('partner.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $questionSets = QuestionSet::where('partner_id', 1)
            ->where('status', 'published')
            ->get();
        return view('partner.exams.edit', compact('exam', 'questionSets'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'question_set_id' => 'required|exists:question_sets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'allow_retake' => 'boolean',
            'show_results_immediately' => 'boolean',
        ]);

        $data = $request->all();
        $data['allow_retake'] = $request->has('allow_retake');
        $data['show_results_immediately'] = $request->has('show_results_immediately');

        $exam->update($data);

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('partner.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }

    public function publish(Exam $exam)
    {
        $exam->update(['status' => 'published']);

        return redirect()->route('partner.exams.show', $exam)
            ->with('success', 'Exam published successfully.');
    }

    public function unpublish(Exam $exam)
    {
        $exam->update(['status' => 'draft']);

        return redirect()->route('partner.exams.show', $exam)
            ->with('success', 'Exam unpublished successfully.');
    }

    public function results(Exam $exam)
    {
        $results = StudentExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->latest()
            ->paginate(20);

        return view('partner.exams.results', compact('exam', 'results'));
    }

    public function export(Exam $exam)
    {
        $results = StudentExamResult::where('exam_id', $exam->id)
            ->with('student')
            ->get();

        // For now, return a simple view. In a real app, you'd generate CSV/PDF
        return view('partner.exams.export', compact('exam', 'results'));
    }
}
