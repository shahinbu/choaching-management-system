@extends('layouts.app')

@section('title', 'Create Question Set')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Question Set</h1>
            <p class="text-gray-600 dark:text-gray-400">Group questions together for exams</p>
        </div>
        <a href="{{ route('partner.question-sets.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Question Sets
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('partner.question-sets.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Question Set Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-md border p-2">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Time Limit (minutes, optional)</label>
                    <input type="number" name="time_limit" value="{{ old('time_limit') }}" min="1"
                           class="w-full rounded-md border p-2">
                    @error('time_limit')
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

            <div class="flex justify-end space-x-3">
                <a href="{{ route('partner.question-sets.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    Create Question Set
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 