@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Student Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome, {{ $student->full_name ?? 'Student' }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('student.exams.available') }}" 
               class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Take Exam
            </a>
            <a href="{{ route('student.exams.history') }}" 
               class="bg-primaryOrange hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Exam History
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Exams Taken -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Exams Taken</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_exams_taken'] }}</p>
                </div>
            </div>
        </div>

        <!-- Passed Exams -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Passed Exams</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['passed_exams'] }}</p>
                </div>
            </div>
        </div>

        <!-- Average Score -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Average Score</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($stats['average_score'], 1) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Exams -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Available Exams</h3>
        </div>
        <div class="p-6">
            @if($available_exams->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($available_exams as $exam)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $exam->title }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $exam->questionSet->name }}</p>
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <span>Duration: {{ $exam->duration }} min</span>
                                <span>Questions: {{ $exam->questionSet->total_questions }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Ends: {{ $exam->end_time->format('M d, H:i') }}
                                </span>
                                <a href="{{ route('student.exams.start', $exam) }}" 
                                   class="bg-primaryGreen hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Start Exam
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No exams available at the moment.</p>
            @endif
        </div>
    </div>

    <!-- Recent Results -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Results</h3>
        </div>
        <div class="p-6">
            @if($recent_results->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_results as $result)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $result->exam->title }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $result->completed_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($result->percentage, 1) }}%
                                </p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($result->percentage >= 80) bg-green-100 text-green-800
                                    @elseif($result->percentage >= 60) bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $result->grade }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No exam results yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection 