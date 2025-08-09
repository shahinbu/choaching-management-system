@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Add Student</h1>
            <p class="text-gray-600 dark:text-gray-400">Enter student information</p>
        </div>
        <a href="{{ route('partner.students.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            Back to Students
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <form action="{{ route('partner.students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Student Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Student Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required
                               class="w-full rounded-md border p-2">
                        @error('full_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Student ID (Optional)</label>
                        <input type="text" name="student_id" value="{{ old('student_id') }}"
                               class="w-full rounded-md border p-2">
                        @error('student_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                               class="w-full rounded-md border p-2">
                        @error('date_of_birth')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Gender</label>
                        <select name="gender" required class="w-full rounded-md border p-2">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full rounded-md border p-2">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full rounded-md border p-2">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="w-full rounded-md border p-2">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full rounded-md border p-2">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Academic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">School/College</label>
                        <input type="text" name="school_college" value="{{ old('school_college') }}"
                               class="w-full rounded-md border p-2">
                        @error('school_college')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Class/Grade</label>
                        <input type="text" name="class_grade" value="{{ old('class_grade') }}"
                               class="w-full rounded-md border p-2">
                        @error('class_grade')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Parent Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Parent Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Parent Name</label>
                        <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                               class="w-full rounded-md border p-2">
                        @error('parent_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Parent Phone</label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone') }}"
                               class="w-full rounded-md border p-2">
                        @error('parent_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Student Photo -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Student Photo</label>
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="file" name="photo" accept="image/*" class="flex-1">
                </div>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('partner.students.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit" class="bg-primaryGreen hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    Add Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 