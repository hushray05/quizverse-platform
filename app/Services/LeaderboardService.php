<?php

namespace App\Services;

use App\Models\User;
use App\Models\QuizAttempt;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LeaderboardService
{
    /**
     * Get global leaderboard ranked by XP.
     */
    public function getGlobalLeaderboard(int $perPage = 15): LengthAwarePaginator
    {
        return User::where('is_banned', false)
            ->where('role', 'player')
            ->orderByDesc('xp')
            ->orderByDesc('streak')
            ->paginate($perPage);
    }

    /**
     * Get weekly top performers by score earned in the last 7 days.
     */
    public function getWeeklyLeaderboard(int $limit = 10)
    {
        return QuizAttempt::where('completed_at', '>=', now()->subDays(7))
            ->select('user_id', DB::raw('SUM(score) as total_score'), DB::raw('SUM(xp_earned) as total_xp'), DB::raw('COUNT(id) as quizzes_completed'))
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total_score')
            ->take($limit)
            ->get();
    }

    /**
     * Get category leaders.
     */
    public function getCategoryLeaderboard(int $categoryId, int $limit = 10)
    {
        return QuizAttempt::join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
            ->where('quizzes.category_id', $categoryId)
            ->select('quiz_attempts.user_id', DB::raw('SUM(quiz_attempts.score) as total_score'), DB::raw('COUNT(quiz_attempts.id) as attempts_count'))
            ->groupBy('quiz_attempts.user_id')
            ->with('user')
            ->orderByDesc('total_score')
            ->take($limit)
            ->get();
    }
}
