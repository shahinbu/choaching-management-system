<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('subjects')->latest()->paginate(15);
        return view('partner.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('partner.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'description' => 'nullable|string',
        ]);

        Course::create($request->all());

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['subjects.topics']);
        return view('partner.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('partner.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'description' => 'nullable|string',
        ]);

        $course->update($request->all());

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('partner.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
