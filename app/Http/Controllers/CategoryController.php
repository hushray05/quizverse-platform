<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Services\AuditService;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Admin: List all categories
     */
    public function index()
    {
        $categories = Category::withCount('quizzes')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Admin: Store new category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $slug = Str::slug($validated['name']);
        // Ensure uniqueness
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        $data = [
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?: 'fa-solid fa-shapes',
            'is_active' => true,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $category = Category::create($data);

        AuditService::log('category_created', 'info', 'Category', $category->id);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' created successfully.");
    }

    /**
     * Admin: Update category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?: $category->icon,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $category->update($data);

        AuditService::log('category_updated', 'info', 'Category', $category->id);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' updated successfully.");
    }

    /**
     * Admin: Delete category
     */
    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        AuditService::log('category_deleted', 'warning', 'Category', $category->id);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category '{$name}' deleted successfully.");
    }

    /**
     * Player: Show category details & quizzes
     */
    public function show(string $slug, LeaderboardService $leaderboardService)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->withCount(['quizzes' => function ($q) {
                $q->where('is_published', true);
            }])
            ->firstOrFail();

        $quizzes = Quiz::where('category_id', $category->id)
            ->where('is_published', true)
            ->with(['creator'])
            ->withCount('questions')
            ->orderByDesc('plays_count')
            ->paginate(6);

        $categoryLeaders = $leaderboardService->getCategoryLeaderboard($category->id, 5);

        return view('pages.player.category_detail', compact('category', 'quizzes', 'categoryLeaders'));
    }
}
