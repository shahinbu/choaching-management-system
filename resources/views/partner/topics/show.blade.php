@extends('layouts.app')

@section('title', 'Topic Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $topic->name }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Code: {{ $topic->code }} • Subject: {{ $topic->subject->name }} • Course: {{ $topic->subject->course->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('partner.topics.edit', $topic) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Edit</a>
            <a href="{{ route('partner.topics.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">About</h2>
        <div class="text-gray-700 dark:text-gray-300 space-y-1">
            @if($topic->chapter_number)
                <div>Chapter: {{ $topic->chapter_number }}</div>
            @endif
            <div>{{ $topic->description ?: 'No description provided.' }}</div>
        </div>
    </div>
</div>
@endsection


