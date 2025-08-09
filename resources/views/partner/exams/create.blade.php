@extends('layouts.app')

@section('title', 'Create Exam')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Exam</h1>
            <p class="text-gray-600 dark:text-gray-400">Schedule a new exam</p>
        </div>
        <a href="{{ route('partner.exams.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Exams
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('partner.exams.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Exam Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full rounded-md border p-2">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Question Set</label>
                    <select name="question_set_id" required class="w-full rounded-md border p-2">
                        <option value="">Select Question Set</option>
                        @foreach($questionSets as $questionSet)
                            <option value="{{ $questionSet->id }}" {{ old('question_set_id') == $questionSet->id ? 'selected' : '' }}>
                                {{ $questionSet->name }} ({{ $questionSet->total_questions }} questions)
                            </option>
                        @endforeach
                    </select>
                    @error('question_set_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-md border p-2">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Start Time</label>
                    <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" required
                           class="w-full rounded-md border p-2">
                    @error('start_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">End Time</label>
                    <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" required
                           class="w-full rounded-md border p-2">
                    @error('end_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Duration (minutes)</label>
                    <input type="number" name="duration" value="{{ old('duration') }}" min="1" required
                           class="w-full rounded-md border p-2">
                    @error('duration')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Passing Marks (%)</label>
                    <input type="number" name="passing_marks" value="{{ old('passing_marks', 60) }}" min="0" max="100" required
                           class="w-full rounded-md border p-2">
                    @error('passing_marks')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="allow_retake" value="1" {{ old('allow_retake') ? 'checked' : '' }}
                               class="rounded border-gray-300">
                        <span class="ml-2 text-sm">Allow Retake</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="show_results_immediately" value="1" {{ old('show_results_immediately', true) ? 'checked' : '' }}
                               class="rounded border-gray-300">
                        <span class="ml-2 text-sm">Show Results Immediately</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('partner.exams.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    Create Exam
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 