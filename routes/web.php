<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\CvController;
use Illuminate\Support\Facades\Route;

// ===========================
// PUBLIC PORTFOLIO ROUTES
// ===========================
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [PortfolioController::class, 'project'])->name('project.show');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('contact.send');
Route::get('/download-cv', [PortfolioController::class, 'downloadCv'])->name('cv.download');

// ===========================
// ADMIN ROUTES (Protected)
// ===========================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Projects CRUD
    Route::resource('projects', ProjectController::class);

    // Skills CRUD
    Route::resource('skills', SkillController::class);

    // Experiences CRUD
    Route::resource('experiences', ExperienceController::class);

    // Certificates CRUD
    Route::resource('certificates', CertificateController::class);

    // Messages
    Route::resource('messages', MessageController::class)->except(['create', 'store']);
    Route::patch('messages/{message}/mark-read', [MessageController::class, 'markRead'])->name('messages.mark-read');

    // CV Management
    Route::get('cv', [CvController::class, 'index'])->name('cv.index');
    Route::post('cv', [CvController::class, 'store'])->name('cv.store');
    Route::patch('cv/{cv}/activate', [CvController::class, 'activate'])->name('cv.activate');
    Route::delete('cv/{cv}', [CvController::class, 'destroy'])->name('cv.destroy');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect old /dashboard to admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
