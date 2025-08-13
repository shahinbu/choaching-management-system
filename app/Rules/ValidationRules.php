<?php

namespace App\Rules;

class ValidationRules
{
    /**
     * Partner validation rules
     */
    public static function partner($partnerId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:partners,email' . ($partnerId ? ",$partnerId" : ''),
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Student validation rules
     */
    public static function student($studentId = null): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students,student_id' . ($studentId ? ",$studentId" : ''),
            'date_of_birth' => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:students,email' . ($studentId ? ",$studentId" : ''),
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'school_college' => 'required|string|max:255',
            'class_grade' => 'required|string|max:50',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Course validation rules
     */
    public static function course($courseId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code' . ($courseId ? ",$courseId" : ''),
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Subject validation rules
     */
    public static function subject($subjectId = null): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code' . ($subjectId ? ",$subjectId" : ''),
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Topic validation rules
     */
    public static function topic($topicId = null): array
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:topics,code' . ($topicId ? ",$topicId" : ''),
            'description' => 'nullable|string|max:1000',
            'chapter_number' => 'nullable|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Question validation rules
     */
    public static function question($questionId = null): array
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'partner_id' => 'required|exists:partners,id',
            'question_text' => 'required|string|max:2000',
            'option_a' => 'required|string|max:500',
            'option_b' => 'required|string|max:500',
            'option_c' => 'required|string|max:500',
            'option_d' => 'required|string|max:500',
            'correct_answer' => 'required|in:a,b,c,d',
            'explanation' => 'nullable|string|max:2000',
            'difficulty_level' => 'required|integer|in:1,2,3',
            'marks' => 'required|integer|min:1|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Question Set validation rules
     */
    public static function questionSet($questionSetId = null): array
    {
        return [
            'partner_id' => 'required|exists:partners,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'total_questions' => 'required|integer|min:1|max:200',
            'total_marks' => 'required|integer|min:1|max:1000',
            'time_limit' => 'required|integer|min:1|max:600', // minutes
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Exam validation rules
     */
    public static function exam($examId = null): array
    {
        return [
            'partner_id' => 'required|exists:partners,id',
            'question_set_id' => 'required|exists:question_sets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'exam_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:1|max:600', // minutes
            'max_attempts' => 'required|integer|min:1|max:5',
            'passing_marks' => 'required|integer|min:1',
            'instructions' => 'nullable|string|max:2000',
            'is_published' => 'boolean',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Student Exam Result validation rules
     */
    public static function studentExamResult(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'exam_id' => 'required|exists:exams,id',
            'answers' => 'required|json',
            'total_questions' => 'required|integer|min:1',
            'correct_answers' => 'required|integer|min:0',
            'wrong_answers' => 'required|integer|min:0',
            'marks_obtained' => 'required|numeric|min:0',
            'total_marks' => 'required|numeric|min:1',
            'percentage' => 'required|numeric|min:0|max:100',
            'time_taken' => 'required|integer|min:1', // seconds
            'status' => 'required|in:completed,incomplete,cancelled',
        ];
    }

    /**
     * User validation rules
     */
    public static function user($userId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($userId ? ",$userId" : ''),
            'password' => $userId ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,partner,student',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Login validation rules
     */
    public static function login(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ];
    }

    /**
     * Password reset validation rules
     */
    public static function passwordReset(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Profile update validation rules
     */
    public static function profileUpdate($userId): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
        ];
    }

    /**
     * Password update validation rules
     */
    public static function passwordUpdate(): array
    {
        return [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Custom validation messages
     */
    public static function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute must be a string.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'min' => 'The :attribute must be at least :min characters.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            'exists' => 'The selected :attribute is invalid.',
            'in' => 'The selected :attribute is invalid.',
            'integer' => 'The :attribute must be an integer.',
            'numeric' => 'The :attribute must be a number.',
            'date' => 'The :attribute is not a valid date.',
            'date_format' => 'The :attribute does not match the format :format.',
            'before' => 'The :attribute must be a date before :date.',
            'after' => 'The :attribute must be a date after :date.',
            'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
            'boolean' => 'The :attribute field must be true or false.',
            'json' => 'The :attribute must be a valid JSON string.',
            'image' => 'The :attribute must be an image.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'regex' => 'The :attribute format is invalid.',
            'confirmed' => 'The :attribute confirmation does not match.',
        ];
    }

    /**
     * Custom attribute names
     */
    public static function attributes(): array
    {
        return [
            'full_name' => 'full name',
            'student_id' => 'student ID',
            'date_of_birth' => 'date of birth',
            'school_college' => 'school/college',
            'class_grade' => 'class/grade',
            'parent_name' => 'parent name',
            'parent_phone' => 'parent phone',
            'course_id' => 'course',
            'subject_id' => 'subject',
            'topic_id' => 'topic',
            'partner_id' => 'partner',
            'question_set_id' => 'question set',
            'question_text' => 'question',
            'option_a' => 'option A',
            'option_b' => 'option B',
            'option_c' => 'option C',
            'option_d' => 'option D',
            'correct_answer' => 'correct answer',
            'difficulty_level' => 'difficulty level',
            'chapter_number' => 'chapter number',
            'total_questions' => 'total questions',
            'total_marks' => 'total marks',
            'time_limit' => 'time limit',
            'exam_date' => 'exam date',
            'start_time' => 'start time',
            'end_time' => 'end time',
            'max_attempts' => 'maximum attempts',
            'passing_marks' => 'passing marks',
            'is_published' => 'published status',
            'correct_answers' => 'correct answers',
            'wrong_answers' => 'wrong answers',
            'marks_obtained' => 'marks obtained',
            'time_taken' => 'time taken',
            'current_password' => 'current password',
        ];
    }
}
