@extends('layouts.app')

@section('title', 'Exams')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Exams</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage scheduled exams</p>
        </div>
        <a href="{{ route('partner.exams.create') }}" 
           class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Create Exam
        </a>
    </div>

    <!-- Exams List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Exams ({{ $exams->total() }})
            </h2>
        </div>

        @if($exams->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($exams as $exam)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $exam->title }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($exam->status === 'published') bg-green-100 text-green-800
                                        @elseif($exam->status === 'draft') bg-gray-100 text-gray-800
                                        @elseif($exam->status === 'ongoing') bg-blue-100 text-blue-800
                                        @elseif($exam->status === 'completed') bg-purple-100 text-purple-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($exam->status) }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $exam->description }}</p>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div>
                                        <span class="font-medium">Question Set:</span> {{ $exam->questionSet->name }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Duration:</span> {{ $exam->duration }} min
                                    </div>
                                    <div>
                                        <span class="font-medium">Start:</span> {{ $exam->start_time->format('M d, H:i') }}
                                    </div>
                                    <div>
                                        <span class="font-medium">End:</span> {{ $exam->end_time->format('M d, H:i') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('partner.exams.show', $exam) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View
                                </a>
                                <a href="{{ route('partner.exams.edit', $exam) }}" 
                                   class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    Edit
                                </a>
                                @if($exam->status === 'draft')
                                    <form action="{{ route('partner.exams.publish', $exam) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300">
                                            Publish
                                        </button>
                                    </form>
                                @elseif($exam->status === 'published')
                                    <form action="{{ route('partner.exams.unpublish', $exam) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300">
                                            Unpublish
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('partner.exams.destroy', $exam) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            onclick="return confirm('Are you sure you want to delete this exam?')">
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
                {{ $exams->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No exams</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new exam.</p>
                <div class="mt-6">
                    <a href="{{ route('partner.exams.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">
                        Create Exam
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 