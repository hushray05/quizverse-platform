<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Calculate user performance aggregates
        $completedAttempts = QuizAttempt::where('user_id', $user->id)->get();
        $totalQuizzesPlayed = $completedAttempts->count();
        $avgAccuracy = $totalQuizzesPlayed > 0 ? round($completedAttempts->avg('accuracy_percentage'), 1) : 0;
        $totalScore = $completedAttempts->sum('score');

        // Recent attempts with quiz relation
        $recentAttempts = QuizAttempt::where('user_id', $user->id)
            ->with(['quiz.category'])
            ->latest('completed_at')
            ->take(5)
            ->get();

        // Recommended / Featured Quizzes
        $featuredQuizzes = Quiz::where('is_published', true)
            ->with(['category', 'creator'])
            ->withCount('questions')
            ->orderByDesc('is_featured')
            ->orderByDesc('plays_count')
            ->take(4)
            ->get();

        // Active Categories
        $categories = Category::where('is_active', true)
            ->withCount(['quizzes' => function ($q) {
                $q->where('is_published', true);
            }])
            ->take(8)
            ->get();

        // Active Banner Campaign
        $activeCampaign = Campaign::active()->where('type', 'banner')->first();

        // XP Next Level Calculation
        $currentLevelBaseXp = ($user->level - 1) ** 2 * 100;
        $nextLevelXp = $user->level ** 2 * 100;
        $levelProgress = max(0, min(100, round((($user->xp - $currentLevelBaseXp) / max(1, $nextLevelXp - $currentLevelBaseXp)) * 100)));

        return view('pages.player.dashboard', compact(
            'user',
            'totalQuizzesPlayed',
            'avgAccuracy',
            'totalScore',
            'recentAttempts',
            'featuredQuizzes',
            'categories',
            'activeCampaign',
            'levelProgress',
            'nextLevelXp'
        ));
    }

    public function welcome()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['quizzes' => function ($q) {
                $q->where('is_published', true);
            }])
            ->get();

        $trendingQuizzes = Quiz::where('is_published', true)
            ->with(['category', 'creator'])
            ->withCount('questions')
            ->orderByDesc('plays_count')
            ->take(6)
            ->get();

        $dailyQuiz = Quiz::where('is_published', true)
            ->where('is_featured', true)
            ->with(['category'])
            ->withCount('questions')
            ->first();

        if (!$dailyQuiz) {
            $dailyQuiz = Quiz::where('is_published', true)
                ->with(['category'])
                ->withCount('questions')
                ->first();
        }

        $stats = [
            'quizzes' => Quiz::where('is_published', true)->count(),
            'players' => \App\Models\User::where('role', 'player')->count(),
            'plays' => QuizAttempt::count(),
        ];

        return view('welcome', compact('categories', 'trendingQuizzes', 'dailyQuiz', 'stats'));
    }
}
