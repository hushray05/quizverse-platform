<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminOverviewController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalQuizzes = Quiz::count();
        $totalAttempts = QuizAttempt::count();
        $activeCampaigns = Campaign::active()->count();

        // 7-day plays trend data for Chart.js
        $trendData = [];
        $trendLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendLabels[] = now()->subDays($i)->format('M d');
            $trendData[] = QuizAttempt::whereDate('completed_at', $date)->count();
        }

        // Category breakdown
        $categoriesBreakdown = Category::withCount('quizzes')->get();

        // Recent audit trails
        $recentAuditLogs = AuditLog::with('user')->latest('created_at')->take(6)->get();

        // Recent registered users
        $recentUsers = User::latest()->take(5)->get();

        return view('pages.admin.overview', compact(
            'totalUsers',
            'totalQuizzes',
            'totalAttempts',
            'activeCampaigns',
            'trendLabels',
            'trendData',
            'categoriesBreakdown',
            'recentAuditLogs',
            'recentUsers'
        ));
    }
}
