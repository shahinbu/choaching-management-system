@extends('layouts.app')

@section('title', 'Questions')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Questions</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage your MCQ questions</p>
        </div>
        <a href="{{ route('partner.questions.create') }}" 
           class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Add Question
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Course</label>
                <select name="course" class="w-full rounded-md border p-2">
                    <option value="">All Courses</option>
                    @foreach($courses ?? [] as $course)
                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Subject</label>
                <select name="subject" class="w-full rounded-md border p-2">
                    <option value="">All Subjects</option>
                    @foreach($subjects ?? [] as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Difficulty</label>
                <select name="difficulty" class="w-full rounded-md border p-2">
                    <option value="">All Levels</option>
                    <option value="1" {{ request('difficulty') == '1' ? 'selected' : '' }}>Easy</option>
                    <option value="2" {{ request('difficulty') == '2' ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ request('difficulty') == '3' ? 'selected' : '' }}>Hard</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Questions List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Questions ({{ $questions->total() }})
            </h2>
        </div>

        @if($questions->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($questions as $question)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($question->difficulty_level == 1) bg-green-100 text-green-800
                                        @elseif($question->difficulty_level == 2) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $question->difficulty_text }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $question->topic->subject->course->name }} > {{ $question->topic->subject->name }} > {{ $question->topic->name }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    {{ Str::limit($question->question_text, 150) }}
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <div>A) {{ Str::limit($question->option_a, 50) }}</div>
                                    <div>B) {{ Str::limit($question->option_b, 50) }}</div>
                                    <div>C) {{ Str::limit($question->option_c, 50) }}</div>
                                    <div>D) {{ Str::limit($question->option_d, 50) }}</div>
                                </div>
                                
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium">Correct Answer:</span> Option {{ strtoupper($question->correct_answer) }}
                                    <span class="mx-2">•</span>
                                    <span class="font-medium">Marks:</span> {{ $question->marks }}
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('partner.questions.show', $question) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View
                                </a>
                                <a href="{{ route('partner.questions.edit', $question) }}" 
                                   class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    Edit
                                </a>
                                <form action="{{ route('partner.questions.destroy', $question) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            onclick="return confirm('Are you sure you want to delete this question?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $questions->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No questions</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new question.</p>
                <div class="mt-6">
                    <a href="{{ route('partner.questions.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">
                        Add Question
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 