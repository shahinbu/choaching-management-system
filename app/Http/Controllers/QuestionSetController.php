<?php

namespace App\Http\Controllers;

use App\Models\QuestionSet;
use App\Models\Question;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class QuestionSetController extends Controller
{
    public function index()
    {
        $questionSets = QuestionSet::with(['partner'])
            ->where('partner_id', 1) // Default partner ID
            ->latest()
            ->paginate(15);
        return view('partner.question-sets.index', compact('questionSets'));
    }

    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->with('course')->get();
        $topics = Topic::where('status', 'active')->with('subject')->get();
        
        // Get available questions with filters
        $questions = Question::with(['topic.subject.course'])
            ->where('partner_id', 1)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('partner.question-sets.create', compact('courses', 'subjects', 'topics', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'time_limit' => 'required|integer|min:1|max:600',
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
            'difficulty_level' => 'nullable|in:1,2,3',
            'randomize_questions' => 'boolean',
            'show_results' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals from selected questions
            $selectedQuestions = Question::whereIn('id', $request->question_ids)->get();
            $totalQuestions = $selectedQuestions->count();
            $totalMarks = $selectedQuestions->sum('marks');

            $questionSet = QuestionSet::create([
                'partner_id' => 1, // Default partner ID
                'name' => $request->name,
                'description' => $request->description,
                'total_questions' => $totalQuestions,
                'total_marks' => $totalMarks,
                'time_limit' => $request->time_limit,
                'difficulty_level' => $request->difficulty_level,
                'randomize_questions' => $request->boolean('randomize_questions'),
                'show_results' => $request->boolean('show_results', true),
                'status' => 'active',
            ]);

            // Attach questions with order
            $order = 1;
            foreach ($request->question_ids as $questionId) {
                $questionSet->questions()->attach($questionId, ['order' => $order++]);
            }

            DB::commit();

            return redirect()->route('partner.question-sets.index')
                ->with('success', 'Question set created successfully with ' . $totalQuestions . ' questions.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create question set. Please try again.']);
        }
    }

    public function show(QuestionSet $questionSet)
    {
        $questionSet->load(['questions.topic.subject.course', 'partner']);
        return view('partner.question-sets.show', compact('questionSet'));
    }

    public function edit(QuestionSet $questionSet)
    {
        return view('partner.question-sets.edit', compact('questionSet'));
    }

    public function update(Request $request, QuestionSet $questionSet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
        ]);

        $questionSet->update($request->all());

        return redirect()->route('partner.question-sets.index')
            ->with('success', 'Question set updated successfully.');
    }

    public function destroy(QuestionSet $questionSet)
    {
        $questionSet->delete();

        return redirect()->route('partner.question-sets.index')
            ->with('success', 'Question set deleted successfully.');
    }

    public function addQuestions(Request $request, QuestionSet $questionSet)
    {
        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id',
        ]);

        $questionIds = $request->question_ids;
        $order = $questionSet->questions()->count() + 1;

        foreach ($questionIds as $questionId) {
            $questionSet->questions()->attach($questionId, ['order' => $order++]);
        }

        $questionSet->updateTotals();

        return redirect()->route('partner.question-sets.show', $questionSet)
            ->with('success', 'Questions added to set successfully.');
    }

    public function removeQuestion(QuestionSet $questionSet, Question $question)
    {
        $questionSet->questions()->detach($question->id);
        $questionSet->updateTotals();

        return redirect()->route('partner.question-sets.show', $questionSet)
            ->with('success', 'Question removed from set successfully.');
    }

    public function downloadPdf(QuestionSet $questionSet)
    {
        $questionSet->load(['questions.topic.subject.course', 'partner']);
        
        $pdf = Pdf::loadView('partner.question-sets.pdf', compact('questionSet'))
            ->setPaper('a4', 'portrait');
        
        return $pdf->download($questionSet->name . '_questions.pdf');
    }

    public function downloadWord(QuestionSet $questionSet)
    {
        $questionSet->load(['questions.topic.subject.course', 'partner']);
        
        $content = view('partner.question-sets.word', compact('questionSet'))->render();
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . $questionSet->name . '_questions.docx"',
        ];
        
        return response($content, 200, $headers);
    }

    public function share(QuestionSet $questionSet)
    {
        $shareUrl = route('partner.question-sets.public', $questionSet->id);
        $shareData = [
            'url' => $shareUrl,
            'title' => $questionSet->name,
            'description' => $questionSet->description ?: 'Question Set with ' . $questionSet->total_questions . ' questions',
            'image' => asset('images/question-set-preview.png'), // Add a default image
        ];

        return view('partner.question-sets.share', compact('questionSet', 'shareData'));
    }

    public function publicView($id)
    {
        $questionSet = QuestionSet::with(['questions.topic.subject.course', 'partner'])
            ->where('status', 'active')
            ->findOrFail($id);
        
        return view('partner.question-sets.public', compact('questionSet'));
    }

    public function getQuestions(Request $request)
    {
        $query = Question::with(['topic.subject.course'])
            ->where('partner_id', 1)
            ->where('status', 'active');

        // Apply filters
        if ($request->filled('course_id')) {
            $query->whereHas('topic.subject', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->whereHas('topic', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        if ($request->filled('difficulty_level')) {
            $query->where('difficulty_level', $request->difficulty_level);
        }

        if ($request->filled('search')) {
            $query->where('question_text', 'LIKE', '%' . $request->search . '%');
        }

        $questions = $query->latest()->get();

        return response()->json($questions);
    }

    public function duplicate(QuestionSet $questionSet)
    {
        DB::beginTransaction();
        try {
            $newQuestionSet = $questionSet->replicate();
            $newQuestionSet->name = $questionSet->name . ' (Copy)';
            $newQuestionSet->save();

            // Copy question relationships
            foreach ($questionSet->questions as $question) {
                $newQuestionSet->questions()->attach($question->id, [
                    'order' => $question->pivot->order
                ]);
            }

            DB::commit();

            return redirect()->route('partner.question-sets.index')
                ->with('success', 'Question set duplicated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to duplicate question set.']);
        }
    }
}
