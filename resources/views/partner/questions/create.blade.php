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
                    <select id="course_id" name="course_id" class="w-full rounded-md border p-2">
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Subject</label>
                    <select id="subject_id" name="subject_id" class="w-full rounded-md border p-2">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" data-course-id="{{ $subject->course_id }}">{{ $subject->name }} ({{ $subject->course->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Topic</label>
                    <select name="topic_id" id="topic_id" class="w-full rounded-md border p-2" required>
                        <option value="">Select Topic</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}" data-subject-id="{{ $topic->subject_id }}">{{ $topic->name }} ({{ $topic->subject->name }})</option>
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const courseSelect = document.getElementById('course_id');
        const subjectSelect = document.getElementById('subject_id');
        const topicSelect = document.getElementById('topic_id');

        // Store original options
        const allSubjects = Array.from(subjectSelect.querySelectorAll('option')).slice(1); // Skip first "Select Subject"
        const allTopics = Array.from(topicSelect.querySelectorAll('option')).slice(1); // Skip first "Select Topic"

        function filterSubjects(courseId) {
            // Clear subjects except first option
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            
            if (!courseId) {
                // Show all subjects if no course selected
                allSubjects.forEach(opt => subjectSelect.appendChild(opt.cloneNode(true)));
                return;
            }

            // Filter subjects by course
            allSubjects
                .filter(opt => opt.dataset.courseId == courseId)
                .forEach(opt => subjectSelect.appendChild(opt.cloneNode(true)));
        }

        function filterTopics(subjectId) {
            // Clear topics except first option
            topicSelect.innerHTML = '<option value="">Select Topic</option>';
            
            if (!subjectId) {
                // Show all topics if no subject selected
                allTopics.forEach(opt => topicSelect.appendChild(opt.cloneNode(true)));
                return;
            }

            // Filter topics by subject
            allTopics
                .filter(opt => opt.dataset.subjectId == subjectId)
                .forEach(opt => topicSelect.appendChild(opt.cloneNode(true)));
        }

        courseSelect?.addEventListener('change', function () {
            const courseId = this.value;
            filterSubjects(courseId);
            filterTopics(''); // Reset topics when course changes
        });

        subjectSelect?.addEventListener('change', function () {
            const subjectId = this.value;
            filterTopics(subjectId);
        });
    });
</script>
@endpush
@endsection 