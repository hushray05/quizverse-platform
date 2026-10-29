<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request, LeaderboardService $leaderboardService)
    {
        $categories = Category::where('is_active', true)->get();
        $globalLeaders = $leaderboardService->getGlobalLeaderboard(15);
        $weeklyLeaders = $leaderboardService->getWeeklyLeaderboard(5);

        return view('pages.player.leaderboard', compact('globalLeaders', 'weeklyLeaders', 'categories'));
    }
}
