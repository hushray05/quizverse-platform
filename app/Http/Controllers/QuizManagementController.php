<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizManagementController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('user_id', Auth::id())
            ->with('category')
            ->withCount('questions')
            ->latest()
            ->paginate(10);

        return view('pages.creator.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('pages.creator.quizzes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'time_limit_per_question' => ['required', 'integer', 'min:5', 'max:120'],
            'xp_reward' => ['required', 'integer', 'min:10', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($data['title']);
        $count = Quiz::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $quiz = Quiz::create([
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'user_id' => Auth::id(),
            'difficulty' => $data['difficulty'],
            'time_limit_per_question' => $data['time_limit_per_question'],
            'xp_reward' => $data['xp_reward'],
            'is_published' => $request->boolean('is_published', true),
        ]);

        AuditService::log('quiz_created', 'info', 'Quiz', $quiz->id, ['title' => $quiz->title]);

        return redirect()->route('creator.quizzes.index')
            ->with('success', "Quiz '{$quiz->title}' initialized. Add questions from your Question Bank.");
    }

    public function edit(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->get();
        $quiz->load(['questions.options']);

        return view('pages.creator.quizzes.edit', compact('quiz', 'categories'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'time_limit_per_question' => ['required', 'integer', 'min:5', 'max:120'],
            'xp_reward' => ['required', 'integer', 'min:10', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $quiz->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'difficulty' => $data['difficulty'],
            'time_limit_per_question' => $data['time_limit_per_question'],
            'xp_reward' => $data['xp_reward'],
            'is_published' => $request->boolean('is_published'),
        ]);

        AuditService::log('quiz_updated', 'info', 'Quiz', $quiz->id, ['title' => $quiz->title]);

        return redirect()->route('creator.quizzes.index')
            ->with('success', "Quiz '{$quiz->title}' updated successfully.");
    }

    public function togglePublish(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $quiz->update(['is_published' => !$quiz->is_published]);

        $status = $quiz->is_published ? 'published' : 'draft';
        AuditService::log('quiz_visibility_toggled', 'info', 'Quiz', $quiz->id, ['status' => $status]);

        return back()->with('success', "Quiz status transitioned to {$status}.");
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $title = $quiz->title;
        $quiz->delete();

        AuditService::log('quiz_deleted', 'warning', 'Quiz', $quiz->id, ['title' => $title]);

        return redirect()->route('creator.quizzes.index')
            ->with('success', "Quiz '{$title}' removed.");
    }
}
