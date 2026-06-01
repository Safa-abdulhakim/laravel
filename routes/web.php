<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPromptController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\LanguageController;

// Language Switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/prompts', [PromptController::class, 'index'])->name('prompts.index');
Route::get('/prompts/{prompt}', [PromptController::class, 'show'])->name('prompts.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Auth Required Routes
Route::middleware(['auth'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // My Prompts
    Route::get('/my-prompts', [PromptController::class, 'myIndex'])->name('my-prompts.index');
    Route::get('/my-prompts/create', [PromptController::class, 'create'])->name('my-prompts.create');
    Route::post('/my-prompts', [PromptController::class, 'store'])->name('my-prompts.store');
    Route::get('/my-prompts/{prompt}/edit', [PromptController::class, 'edit'])->name('my-prompts.edit');
    Route::put('/my-prompts/{prompt}', [PromptController::class, 'update'])->name('my-prompts.update');
    Route::delete('/my-prompts/{prompt}', [PromptController::class, 'destroy'])->name('my-prompts.destroy');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{prompt}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Admin Routes
Route::middleware(['auth', 'check.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Prompts
    Route::get('/prompts', [AdminPromptController::class, 'index'])->name('prompts.index');
    Route::get('/prompts/create', [AdminPromptController::class, 'create'])->name('prompts.create');
    Route::post('/prompts', [AdminPromptController::class, 'store'])->name('prompts.store');
    Route::get('/prompts/{prompt}/edit', [AdminPromptController::class, 'edit'])->name('prompts.edit');
    Route::put('/prompts/{prompt}', [AdminPromptController::class, 'update'])->name('prompts.update');
    Route::delete('/prompts/{prompt}', [AdminPromptController::class, 'destroy'])->name('prompts.destroy');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Tags
    Route::get('/tags', [AdminTagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create', [AdminTagController::class, 'create'])->name('tags.create');
    Route::post('/tags', [AdminTagController::class, 'store'])->name('tags.store');
    Route::get('/tags/{tag}/edit', [AdminTagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [AdminTagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [AdminTagController::class, 'destroy'])->name('tags.destroy');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
