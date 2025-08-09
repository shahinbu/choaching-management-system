<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with(['course'])->withCount('topics')->latest()->paginate(15);
        return view('partner.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        return view('partner.subjects.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'description' => 'nullable|string',
        ]);

        Subject::create($request->all());

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load(['course', 'topics']);
        return view('partner.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $courses = Course::where('status', 'active')->get();
        return view('partner.subjects.edit', compact('subject', 'courses'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
        ]);

        $subject->update($request->all());

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('partner.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
