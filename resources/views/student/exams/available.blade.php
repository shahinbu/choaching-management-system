@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Available Exams</h1>
            <p class="text-gray-600 dark:text-gray-400">Take exams that are currently available</p>
        </div>
        <a href="{{ route('student.dashboard') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Dashboard
        </a>
    </div>

    <!-- Available Exams -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Available Exams ({{ $availableExams->count() }})
            </h2>
        </div>

        @if($availableExams->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($availableExams as $exam)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $exam->title }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Available
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $exam->description }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Question Set:</span>
                                <span class="font-medium">{{ $exam->questionSet->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Questions:</span>
                                <span class="font-medium">{{ $exam->questionSet->total_questions }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Duration:</span>
                                <span class="font-medium">{{ $exam->duration }} minutes</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Total Marks:</span>
                                <span class="font-medium">{{ $exam->questionSet->total_marks }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Passing Marks:</span>
                                <span class="font-medium">{{ $exam->passing_marks }}%</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span>Ends: {{ $exam->end_time->format('M d, H:i') }}</span>
                            </div>
                            
                            <a href="{{ route('student.exams.start', $exam) }}" 
                               class="w-full bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md text-center block transition-colors duration-200">
                                Start Exam
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No exams available</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are no exams available at the moment.</p>
                <div class="mt-6">
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 