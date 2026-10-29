<?php

use App\Http\Controllers\AdminOverviewController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreatorDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\GameplayController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PlatformSettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionBankController;
use App\Http\Controllers\QuestionEditorController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizManagementController;
use App\Http\Controllers\RbacController;
use App\Http\Controllers\UserModerationController;
use Illuminate\Support\Facades\Route;

// Frontend Playable Quiz Arena (/quiz)
Route::get('/quiz', [QuizController::class, 'playFrontend'])->name('quiz.index');
Route::get('/quiz/{id}', [QuizController::class, 'playFrontend'])->name('quiz.play');
Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submitFrontend'])->name('quiz.submit');

// Public / Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Homepage - Public
Route::get('/', [DashboardController::class, 'welcome'])->name('home');

// Fast role switcher for testing / demo evaluation
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Player Core
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
    
    // Gameplay Arena
    Route::get('/play/quick', [GameplayController::class, 'quickPlay'])->name('play.quick');
    Route::get('/play/daily', [GameplayController::class, 'dailyChallenge'])->name('play.daily');
    Route::get('/play/{slug}', [GameplayController::class, 'play'])->name('play.quiz');
    Route::post('/play/{slug}/submit', [GameplayController::class, 'submitAttempt'])->name('play.submit');
    Route::get('/play/results/{attempt}', [GameplayController::class, 'results'])->name('play.results');

    // Leaderboards & Profile
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Creator Suite
    Route::middleware('creator')->prefix('creator')->name('creator.')->group(function () {
        Route::get('/', [CreatorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [CreatorDashboardController::class, 'index']);
        
        // Quizzes
        Route::get('/quizzes', [QuizManagementController::class, 'index'])->name('quizzes.index');
        Route::get('/quizzes/create', [QuizManagementController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [QuizManagementController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{quiz}/edit', [QuizManagementController::class, 'edit'])->name('quizzes.edit');
        Route::put('/quizzes/{quiz}', [QuizManagementController::class, 'update'])->name('quizzes.update');
        Route::post('/quizzes/{quiz}/toggle-publish', [QuizManagementController::class, 'togglePublish'])->name('quizzes.toggle-publish');
        Route::delete('/quizzes/{quiz}', [QuizManagementController::class, 'destroy'])->name('quizzes.destroy');

        // Questions
        Route::get('/questions', [QuestionBankController::class, 'index'])->name('questions.index');
        Route::get('/questions/create', [QuestionEditorController::class, 'create'])->name('questions.create');
        Route::post('/questions', [QuestionEditorController::class, 'store'])->name('questions.store');
        Route::get('/questions/{question}/edit', [QuestionEditorController::class, 'edit'])->name('questions.edit');
        Route::put('/questions/{question}', [QuestionEditorController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [QuestionBankController::class, 'destroy'])->name('questions.destroy');
        Route::post('/questions/bulk-delete', [QuestionBankController::class, 'bulkDelete'])->name('questions.bulk-delete');
    });

    // Admin Control Plane
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminOverviewController::class, 'index'])->name('overview');
        Route::get('/overview', [AdminOverviewController::class, 'index']);
        Route::get('/dashboard', [AdminOverviewController::class, 'index']);
        
        // Category Management
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Quiz Management
        Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

        // Users & Moderation
        Route::get('/users', [UserModerationController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-ban', [UserModerationController::class, 'toggleBan'])->name('users.toggle-ban');
        Route::post('/users/{user}/change-role', [UserModerationController::class, 'changeRole'])->name('users.change-role');

        // RBAC & Staff
        Route::get('/rbac', [RbacController::class, 'index'])->name('rbac.index');
        Route::post('/rbac/assign', [RbacController::class, 'assignStaff'])->name('rbac.assign');
        Route::post('/rbac/staff/{staff}/toggle', [RbacController::class, 'toggleStaffStatus'])->name('rbac.toggle');

        // Settings
        Route::get('/settings', [PlatformSettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [PlatformSettingsController::class, 'update'])->name('settings.update');

        // Audit Logs
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
        Route::get('/audit', [AuditLogController::class, 'index']);

        // Analytics
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

        // Ad Campaigns
        Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
        Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
        Route::post('/campaigns/{campaign}/toggle', [CampaignController::class, 'toggleStatus'])->name('campaigns.toggle');
        Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
    });
});
