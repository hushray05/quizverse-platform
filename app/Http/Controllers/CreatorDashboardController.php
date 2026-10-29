<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class CreatorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalQuizzes = Quiz::where('user_id', $user->id)->count();
        $totalQuestions = Question::where('user_id', $user->id)->count();
        $totalPlays = Quiz::where('user_id', $user->id)->sum('plays_count');
        $avgRating = Quiz::where('user_id', $user->id)->avg('rating') ?? 4.9;

        $recentQuizzes = Quiz::where('user_id', $user->id)
            ->with('category')
            ->withCount('questions')
            ->latest()
            ->take(5)
            ->get();

        $recentQuestions = Question::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.creator.dashboard', compact(
            'totalQuizzes',
            'totalQuestions',
            'totalPlays',
            'avgRating',
            'recentQuizzes',
            'recentQuestions'
        ));
    }
}
