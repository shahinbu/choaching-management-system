@extends('layouts.app')

@section('title', 'Question Sets')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Question Sets</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage question sets for exams</p>
        </div>
        <a href="{{ route('partner.question-sets.create') }}" 
           class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Create Question Set
        </a>
    </div>

    <!-- Question Sets List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Question Sets ({{ $questionSets->total() }})
            </h2>
        </div>

        @if($questionSets->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($questionSets as $questionSet)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $questionSet->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($questionSet->status === 'published') bg-green-100 text-green-800
                                        @elseif($questionSet->status === 'draft') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($questionSet->status) }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $questionSet->description }}</p>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div>
                                        <span class="font-medium">Questions:</span> {{ $questionSet->total_questions }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Total Marks:</span> {{ $questionSet->total_marks }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Time Limit:</span> 
                                        {{ $questionSet->time_limit ? $questionSet->time_limit . ' min' : 'No limit' }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Created:</span> {{ $questionSet->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('partner.question-sets.show', $questionSet) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View
                                </a>
                                <a href="{{ route('partner.question-sets.edit', $questionSet) }}" 
                                   class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    Edit
                                </a>
                                <form action="{{ route('partner.question-sets.destroy', $questionSet) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            onclick="return confirm('Are you sure you want to delete this question set?')">
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
                {{ $questionSets->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No question sets</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new question set.</p>
                <div class="mt-6">
                    <a href="{{ route('partner.question-sets.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">
                        Create Question Set
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 