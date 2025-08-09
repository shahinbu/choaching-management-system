@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Students</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage student information</p>
        </div>
        <a href="{{ route('partner.students.create') }}" 
           class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
            Add Student
        </a>
    </div>

    <!-- Students List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Students ({{ $students->total() }})
            </h2>
        </div>

        @if($students->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($students as $student)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($student->photo)
                                        <img class="h-12 w-12 rounded-full" src="{{ Storage::url($student->photo) }}" alt="{{ $student->full_name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-gray-600 dark:text-gray-400 font-medium">
                                                {{ substr($student->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $student->full_name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $student->email }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $student->school_college }} • {{ $student->class_grade }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($student->status === 'active') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($student->status) }}
                                </span>
                                <a href="{{ route('partner.students.show', $student) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View
                                </a>
                                <a href="{{ route('partner.students.edit', $student) }}" 
                                   class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    Edit
                                </a>
                                <form action="{{ route('partner.students.destroy', $student) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            onclick="return confirm('Are you sure you want to delete this student?')">
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
                {{ $students->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No students</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new student.</p>
                <div class="mt-6">
                    <a href="{{ route('partner.students.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primaryGreen hover:bg-green-600">
                        Add Student
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 