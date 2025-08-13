@extends('layouts.app')

@section('title', 'Create Question Set')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Question Set</h1>
            <p class="text-gray-600 dark:text-gray-400">Select questions and create a new question set</p>
        </div>
        <a href="{{ route('partner.question-sets.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Question Sets
        </a>
    </div>

    <form action="{{ route('partner.question-sets.store') }}" method="POST" id="questionSetForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Question Set Details -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Question Set Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full rounded-md border p-2" placeholder="Enter question set name">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full rounded-md border p-2" 
                                placeholder="Enter description...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Time Limit (minutes) *</label>
                            <input type="number" name="time_limit" value="{{ old('time_limit', 60) }}" min="1" max="600" required
                                   class="w-full rounded-md border p-2">
                            @error('time_limit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Difficulty Level</label>
                            <select name="difficulty_level" class="w-full rounded-md border p-2">
                                <option value="">Mixed Difficulty</option>
                                <option value="1" {{ old('difficulty_level') == '1' ? 'selected' : '' }}>Easy</option>
                                <option value="2" {{ old('difficulty_level') == '2' ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ old('difficulty_level') == '3' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="randomize_questions" value="1" 
                                       {{ old('randomize_questions') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primaryGreen">
                                <span class="ml-2 text-sm">Randomize question order</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="show_results" value="1" checked
                                       {{ old('show_results', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primaryGreen">
                                <span class="ml-2 text-sm">Show results after completion</span>
                            </label>
                        </div>

                        <!-- Selected Questions Summary -->
                        <div class="border-t pt-4">
                            <h3 class="font-medium text-gray-900 dark:text-white mb-2">Selected Questions</h3>
                            <div id="selectedSummary" class="text-sm text-gray-600 dark:text-gray-400">
                                <div>Count: <span id="selectedCount">0</span></div>
                                <div>Total Marks: <span id="totalMarks">0</span></div>
                            </div>
                        </div>

                        <button type="submit" id="createButton" disabled
                                class="w-full bg-primaryGreen hover:bg-green-600 disabled:bg-gray-400 text-white px-4 py-2 rounded-md transition-colors">
                            Create Question Set
                        </button>
                    </div>
                </div>
            </div>

            <!-- Question Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Select Questions</h2>
                        <div class="flex gap-2">
                            <button type="button" id="selectAll" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                Select All
                            </button>
                            <button type="button" id="deselectAll" class="text-sm bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded">
                                Deselect All
                            </button>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium mb-1">Course</label>
                            <select id="filterCourse" class="w-full rounded-md border p-2 text-sm">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Subject</label>
                            <select id="filterSubject" class="w-full rounded-md border p-2 text-sm">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" data-course-id="{{ $subject->course_id }}">
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Topic</label>
                            <select id="filterTopic" class="w-full rounded-md border p-2 text-sm">
                                <option value="">All Topics</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}" data-subject-id="{{ $topic->subject_id }}">
                                        {{ $topic->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Difficulty</label>
                            <select id="filterDifficulty" class="w-full rounded-md border p-2 text-sm">
                                <option value="">All Levels</option>
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="mb-4">
                        <input type="text" id="searchQuestions" placeholder="Search questions..." 
                               class="w-full rounded-md border p-2">
                    </div>

                    <!-- Questions List -->
                    <div id="questionsList" class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($questions as $question)
                            <div class="question-item border rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                 data-course-id="{{ $question->topic->subject->course_id }}"
                                 data-subject-id="{{ $question->topic->subject_id }}"
                                 data-topic-id="{{ $question->topic_id }}"
                                 data-difficulty="{{ $question->difficulty_level }}"
                                 data-marks="{{ $question->marks }}"
                                 data-question-text="{{ strtolower($question->question_text) }}">
                                
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" 
                                           class="question-checkbox mt-1 rounded border-gray-300 text-primaryGreen">
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                @if($question->difficulty_level == 1) bg-green-100 text-green-800
                                                @elseif($question->difficulty_level == 2) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $question->difficulty_text }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $question->topic->subject->course->name }} > 
                                                {{ $question->topic->subject->name }} > 
                                                {{ $question->topic->name }}
                                            </span>
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">
                                                {{ $question->marks }} marks
                                            </span>
                                        </div>
                                        
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">
                                            {{ Str::limit($question->question_text, 150) }}
                                        </h4>
                                        
                                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-400">
                                            <div>A) {{ Str::limit($question->option_a, 40) }}</div>
                                            <div>B) {{ Str::limit($question->option_b, 40) }}</div>
                                            <div>C) {{ Str::limit($question->option_c, 40) }}</div>
                                            <div>D) {{ Str::limit($question->option_d, 40) }}</div>
                                        </div>
                                        
                                        <div class="mt-2 text-xs text-gray-500">
                                            Correct: Option {{ strtoupper($question->correct_answer) }}
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @if($questions->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <p>No questions available. <a href="{{ route('partner.questions.create') }}" class="text-primaryGreen hover:underline">Create some questions first</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectedCountEl = document.getElementById('selectedCount');
    const totalMarksEl = document.getElementById('totalMarks');
    const createButton = document.getElementById('createButton');
    const selectAllBtn = document.getElementById('selectAll');
    const deselectAllBtn = document.getElementById('deselectAll');
    
    // Filter elements
    const filterCourse = document.getElementById('filterCourse');
    const filterSubject = document.getElementById('filterSubject');
    const filterTopic = document.getElementById('filterTopic');
    const filterDifficulty = document.getElementById('filterDifficulty');
    const searchInput = document.getElementById('searchQuestions');
    
    // Store original options for filtering
    const allSubjects = Array.from(filterSubject.querySelectorAll('option')).slice(1);
    const allTopics = Array.from(filterTopic.querySelectorAll('option')).slice(1);
    
    function updateSummary() {
        const selected = document.querySelectorAll('.question-checkbox:checked');
        const count = selected.length;
        let totalMarks = 0;
        
        selected.forEach(checkbox => {
            const questionItem = checkbox.closest('.question-item');
            totalMarks += parseInt(questionItem.dataset.marks);
        });
        
        selectedCountEl.textContent = count;
        totalMarksEl.textContent = totalMarks;
        createButton.disabled = count === 0;
    }
    
    function filterQuestions() {
        const courseId = filterCourse.value;
        const subjectId = filterSubject.value;
        const topicId = filterTopic.value;
        const difficulty = filterDifficulty.value;
        const searchTerm = searchInput.value.toLowerCase();
        
        document.querySelectorAll('.question-item').forEach(item => {
            let show = true;
            
            if (courseId && item.dataset.courseId !== courseId) show = false;
            if (subjectId && item.dataset.subjectId !== subjectId) show = false;
            if (topicId && item.dataset.topicId !== topicId) show = false;
            if (difficulty && item.dataset.difficulty !== difficulty) show = false;
            if (searchTerm && !item.dataset.questionText.includes(searchTerm)) show = false;
            
            item.style.display = show ? 'block' : 'none';
        });
    }
    
    function filterSubjects(courseId) {
        filterSubject.innerHTML = '<option value="">All Subjects</option>';
        if (!courseId) {
            allSubjects.forEach(opt => filterSubject.appendChild(opt.cloneNode(true)));
            return;
        }
        allSubjects
            .filter(opt => opt.dataset.courseId == courseId)
            .forEach(opt => filterSubject.appendChild(opt.cloneNode(true)));
    }
    
    function filterTopics(subjectId) {
        filterTopic.innerHTML = '<option value="">All Topics</option>';
        if (!subjectId) {
            allTopics.forEach(opt => filterTopic.appendChild(opt.cloneNode(true)));
            return;
        }
        allTopics
            .filter(opt => opt.dataset.subjectId == subjectId)
            .forEach(opt => filterTopic.appendChild(opt.cloneNode(true)));
    }
    
    // Event listeners
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSummary);
    });
    
    selectAllBtn.addEventListener('click', () => {
        document.querySelectorAll('.question-item:not([style*="display: none"]) .question-checkbox').forEach(cb => {
            cb.checked = true;
        });
        updateSummary();
    });
    
    deselectAllBtn.addEventListener('click', () => {
        questionCheckboxes.forEach(cb => cb.checked = false);
        updateSummary();
    });
    
    // Filter event listeners
    filterCourse.addEventListener('change', function() {
        filterSubjects(this.value);
        filterTopic.innerHTML = '<option value="">All Topics</option>';
        filterQuestions();
    });
    
    filterSubject.addEventListener('change', function() {
        filterTopics(this.value);
        filterQuestions();
    });
    
    filterTopic.addEventListener('change', filterQuestions);
    filterDifficulty.addEventListener('change', filterQuestions);
    searchInput.addEventListener('input', filterQuestions);
    
    // Initial update
    updateSummary();
});
</script>
@endpush
@endsection