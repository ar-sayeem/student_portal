<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Assignment Routes
    Route::resource('assignments', AssignmentController::class);
    Route::get('/assignments/{assignment}/download', [AssignmentController::class, 'downloadFile'])->name('assignments.download');
    
    // Submission Routes
    Route::get('/assignments/{assignment}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/assignments/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::resource('submissions', SubmissionController::class)->except(['create', 'store']);
    Route::post('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
    Route::post('/submissions/bulk-grade', [SubmissionController::class, 'bulkGrade'])->name('submissions.bulk-grade');
    Route::get('/submissions/{submission}/download', [SubmissionController::class, 'downloadFile'])->name('submissions.download');
    
    // Result Routes
    Route::resource('results', ResultController::class);
    Route::get('/my-results', [ResultController::class, 'myResults'])->name('results.my');
    
    // Message Routes
    Route::resource('messages', MessageController::class);
    Route::get('/contact-admin', function() {
        return view('messages.contact');
    })->name('messages.contact');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::post('/messages/{message}/mark-read', [MessageController::class, 'markAsRead'])->name('messages.mark-read');
    
    // Student Management Routes (Admin/Teacher only)
    Route::middleware('can:manage-students')->group(function () {
        Route::resource('students', StudentController::class);
        Route::get('/students/{student}/results', [StudentController::class, 'results'])->name('students.results');
        Route::get('/students/{student}/submissions', [StudentController::class, 'submissions'])->name('students.submissions');
    });
});

require __DIR__.'/auth.php';
