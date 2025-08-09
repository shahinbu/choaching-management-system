<?php

namespace App\Http\Controllers;

use App\Models\QuestionSet;
use App\Models\Question;
use Illuminate\Http\Request;

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
        return view('partner.question-sets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
        ]);

        $data = $request->all();
        $data['partner_id'] = 1; // Default partner ID

        QuestionSet::create($data);

        return redirect()->route('partner.question-sets.index')
            ->with('success', 'Question set created successfully.');
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
}
