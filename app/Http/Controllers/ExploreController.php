<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();

        $query = Quiz::where('is_published', true)
            ->with(['category', 'creator'])
            ->withCount('questions');

        // Search query
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        // Sorting
        $sort = $request->input('sort', 'popular');
        match ($sort) {
            'newest' => $query->latest(),
            'rating' => $query->orderByDesc('rating'),
            'reward' => $query->orderByDesc('xp_reward'),
            default => $query->orderByDesc('plays_count'),
        };

        $quizzes = $query->paginate(9)->withQueryString();

        return view('pages.player.explore', compact('quizzes', 'categories'));
    }
}
