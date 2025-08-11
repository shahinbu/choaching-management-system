<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionSetController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Partner Routes (Coaching Center)
Route::prefix('partner')->name('partner.')->group(function () {
    Route::get('/', [PartnerDashboardController::class, 'index'])->name('dashboard');
    
    // Partner Management
    Route::resource('partners', PartnerController::class);
    
    // Course Management
    Route::resource('courses', CourseController::class);
    
    // Subject Management
    Route::resource('subjects', SubjectController::class);
    
    // Topic Management
    Route::resource('topics', TopicController::class);
    
    // Question Management
    Route::resource('questions', QuestionController::class);
    Route::post('questions/check-duplicate', [QuestionController::class, 'checkDuplicate'])->name('questions.check-duplicate');
    // Dependent dropdowns for Question create
    Route::get('questions/subjects', [QuestionController::class, 'getSubjects'])->name('questions.subjects');
    Route::get('questions/topics', [QuestionController::class, 'getTopics'])->name('questions.topics');
    
    // Question Set Management
    Route::resource('question-sets', QuestionSetController::class);
    Route::post('question-sets/{questionSet}/add-questions', [QuestionSetController::class, 'addQuestions'])->name('question-sets.add-questions');
    Route::delete('question-sets/{questionSet}/remove-question/{question}', [QuestionSetController::class, 'removeQuestion'])->name('question-sets.remove-question');
    
    // Exam Management
    Route::resource('exams', ExamController::class);
    Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
    Route::post('exams/{exam}/unpublish', [ExamController::class, 'unpublish'])->name('exams.unpublish');
    Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results');
    Route::get('exams/{exam}/export', [ExamController::class, 'export'])->name('exams.export');
    
    // Student Management
    Route::resource('students', StudentController::class);
});

// Student Routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Student Profile
    Route::resource('profile', StudentController::class)->only(['show', 'edit', 'update']);
    
    // Available Exams
    Route::get('exams', [StudentExamController::class, 'availableExams'])->name('exams.available');
    Route::get('exams/{exam}', [StudentExamController::class, 'showExam'])->name('exams.show');
    
    // Take Exam
    Route::get('exams/{exam}/start', [StudentExamController::class, 'startExam'])->name('exams.start');
    Route::post('exams/{exam}/submit', [StudentExamController::class, 'submitExam'])->name('exams.submit');
    Route::get('exams/{exam}/result', [StudentExamController::class, 'showResult'])->name('exams.result');
    
    // Exam History
    Route::get('history', [StudentExamController::class, 'history'])->name('exams.history');
});
