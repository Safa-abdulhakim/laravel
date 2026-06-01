<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CareerPathController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;

// Language switcher
Route::post('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/career-paths', [CareerPathController::class, 'index'])->name('career-paths.index');
Route::get('/career-paths/{careerPath:slug}', [CareerPathController::class, 'show'])->name('career-paths.show');

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Progress routes
    Route::post('/career-paths/{careerPath}/enroll', [ProgressController::class, 'enrollPath'])
        ->name('career-paths.enroll');
    Route::post('/career-paths/{careerPath}/skills/{skill}/progress', [ProgressController::class, 'update'])
        ->name('progress.update');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('career-paths', Admin\CareerPathController::class);
    Route::resource('stages', Admin\StageController::class);
    Route::resource('skills', Admin\SkillController::class);
    Route::resource('resources', Admin\LearningResourceController::class);

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-role', [Admin\UserController::class, 'toggleRole'])->name('users.toggle-role');
});

require __DIR__.'/auth.php';
