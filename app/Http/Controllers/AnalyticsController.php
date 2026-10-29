<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Plays timeline by day (last 14 days)
        $dailyLabels = [];
        $dailyPlays = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = now()->subDays($i)->format('M d');
            $dailyPlays[] = QuizAttempt::whereDate('completed_at', $date)->count();
        }

        // Category engagement breakdown
        $categoryData = Category::withCount('quizzes')
            ->get()
            ->map(function ($cat) {
                $plays = QuizAttempt::whereHas('quiz', function ($q) use ($cat) {
                    $q->where('category_id', $cat->id);
                })->count();
                return [
                    'name' => $cat->name,
                    'plays' => $plays,
                ];
            });

        // Difficulty distribution
        $difficultyData = [
            'easy' => Quiz::where('difficulty', 'easy')->count(),
            'medium' => Quiz::where('difficulty', 'medium')->count(),
            'hard' => Quiz::where('difficulty', 'hard')->count(),
        ];

        // Player level distribution
        $levelData = [
            'Initiates (Lvl 1-4)' => User::whereBetween('level', [1, 4])->count(),
            'Strategists (Lvl 5-9)' => User::whereBetween('level', [5, 9])->count(),
            'Neural Elite (Lvl 10-14)' => User::whereBetween('level', [10, 14])->count(),
            'Grandmasters (Lvl 15+)' => User::where('level', '>=', 15)->count(),
        ];

        return view('pages.admin.analytics.index', compact(
            'dailyLabels',
            'dailyPlays',
            'categoryData',
            'difficultyData',
            'levelData'
        ));
    }
}
