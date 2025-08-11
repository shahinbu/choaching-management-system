@extends('layouts.app')

@section('title', 'Subject Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $subject->name }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Code: {{ $subject->code }} • Course: {{ $subject->course->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('partner.subjects.edit', $subject) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
            <a href="{{ route('partner.subjects.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">About</h2>
        <p class="text-gray-700 dark:text-gray-300">{{ $subject->description ?: 'No description provided.' }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Topics ({{ $subject->topics->count() }})</h2>
            <a href="{{ route('partner.topics.create') }}" class="bg-primaryGreen hover:bg-green-600 text-white px-3 py-2 rounded-md">Add Topic</a>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($subject->topics as $topic)
                <div class="p-6 flex justify-between items-center">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $topic->name }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">{{ $topic->code }}</span>
                            @if($topic->chapter_number)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-800">Chapter {{ $topic->chapter_number }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $topic->description }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('partner.topics.show', $topic) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        <a href="{{ route('partner.topics.edit', $topic) }}" class="text-green-600 hover:text-green-800">Edit</a>
                    </div>
                </div>
            @empty
                <div class="p-6 text-gray-600 dark:text-gray-400">No topics found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection


