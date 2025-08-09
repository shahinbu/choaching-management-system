@extends('layouts.app')

@section('title', 'Exam History')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Exam History</h1>
            <p class="text-gray-600 dark:text-gray-400">View your past exam results</p>
        </div>
        <a href="{{ route('student.dashboard') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Dashboard
        </a>
    </div>

    <!-- Exam History -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Exam Results ({{ $results->total() }})
            </h2>
        </div>

        @if($results->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($results as $result)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $result->exam->title }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($result->percentage >= 80) bg-green-100 text-green-800
                                        @elseif($result->percentage >= 60) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $result->grade }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $result->exam->questionSet->name }}</p>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div>
                                        <span class="font-medium">Score:</span> {{ number_format($result->percentage, 1) }}%
                                    </div>
                                    <div>
                                        <span class="font-medium">Marks:</span> {{ $result->score }}/{{ $result->exam->questionSet->total_marks }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Correct:</span> {{ $result->correct_answers }}/{{ $result->total_questions }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Completed:</span> {{ $result->completed_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('student.exams.result', $result->exam) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $results->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No exam results</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't taken any exams yet.</p>
                <div class="mt-6">
                    <a href="{{ route('student.exams.available') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">
                        Take an Exam
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 