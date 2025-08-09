@extends('layouts.app')

@section('title', 'Add Course')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Add Course</h1>
            <p class="text-gray-600 dark:text-gray-400">Create a new academic course</p>
        </div>
        <a href="{{ route('partner.courses.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Courses
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('partner.courses.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Course Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-md border p-2">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Course Code</label>
                    <input type="text" name="code" value="{{ old('code') }}" required
                           class="w-full rounded-md border p-2">
                    @error('code')
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
                <a href="{{ route('partner.courses.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    Add Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 