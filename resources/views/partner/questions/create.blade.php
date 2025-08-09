@extends('layouts.app')

@section('title', 'Create Question')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create MCQ Question</h1>
            <p class="text-gray-600 dark:text-gray-400">Add a new multiple-choice question</p>
        </div>
        <a href="{{ route('partner.questions.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Questions
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('partner.questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Course, Subject, Topic -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Course</label>
                    <select id="course" class="w-full rounded-md border p-2">
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Subject</label>
                    <select id="subject" class="w-full rounded-md border p-2">
                        <option value="">Select Subject</option>
                        <option value="">Physics</option>
                        <option value="">History</option>
                        <option value="">Math</option>
                        <option value="">English</option>
                        <option value="">Bangla</option>
                        <option value="">Geography</option>
                        <option value="">Biology</option>
                        <option value="">Chemistry</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach 
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Topic</label>
                    <select name="topic_id" id="topic_id" class="w-full rounded-md border p-2" required>
                        <option value="">Select Topic</option>
                        <option value="">Topic 1</option>
                        <option value="">Topic 2</option>
                        <option value="">Topic 3</option>
                        <option value="">Topic 4</option>
                        <option value="">Topic 5</option>
                        <option value="">Topic 6</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Question Text -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Question</label>
                <textarea name="question_text" rows="3" class="w-full rounded-md border p-2" required 
                    placeholder="Enter your question here...">{{ old('question_text') }}</textarea>
            </div>

            <!-- Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Option A</label>
                    <input type="text" name="option_a" class="w-full rounded-md border p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Option B</label>
                    <input type="text" name="option_b" class="w-full rounded-md border p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Option C</label>
                    <input type="text" name="option_c" class="w-full rounded-md border p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Option D</label>
                    <input type="text" name="option_d" class="w-full rounded-md border p-2" required>
                </div>
            </div>

            <!-- Correct Answer -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Correct Answer</label>
                <select name="correct_answer" class="w-full rounded-md border p-2" required>
                    <option value="">Select Correct Answer</option>
                    <option value="a">Option A</option>
                    <option value="b">Option B</option>
                    <option value="c">Option C</option>
                    <option value="d">Option D</option>
                </select>
            </div>

            <!-- Additional Settings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Difficulty</label>
                    <select name="difficulty_level" class="w-full rounded-md border p-2" required>
                        <option value="1">Easy</option>
                        <option value="2">Medium</option>
                        <option value="3">Hard</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Marks</label>
                    <input type="number" name="marks" value="1" min="1" class="w-full rounded-md border p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Image (Optional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full rounded-md border p-2">
                </div>
            </div>

            <!-- Explanation -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Explanation (Optional)</label>
                <textarea name="explanation" rows="3" class="w-full rounded-md border p-2" 
                    placeholder="Explain why this is the correct answer...">{{ old('explanation') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('partner.questions.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    Create Question
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 