<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\AuditService;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Admin: List all quizzes
     */
    public function index(Request $request)
    {
        $query = Quiz::with(['category', 'creator'])
            ->withCount('questions');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $quizzes = $query->latest()->paginate(10);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.quizzes.index', compact('quizzes', 'categories'));
    }

    /**
     * Admin: Show create quiz form
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.quizzes.create', compact('categories'));
    }

    /**
     * Admin: Store new quiz
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'time_limit_per_question' => ['nullable', 'integer', 'min:5', 'max:120'],
            'question' => ['nullable', 'string'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable', 'string'],
            'correct_answer' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $slug = Str::slug($validated['title']);
        if (Quiz::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        // Clean options array
        $cleanOptions = [];
        if (!empty($validated['options']) && is_array($validated['options'])) {
            $cleanOptions = array_values(array_filter(array_map('trim', $validated['options'])));
        }

        $data = [
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id() ?? 1,
            'difficulty' => $validated['difficulty'],
            'time_limit_per_question' => $validated['time_limit_per_question'] ?? 20,
            'xp_reward' => $validated['difficulty'] === 'hard' ? 250 : ($validated['difficulty'] === 'medium' ? 150 : 100),
            'is_published' => true,
            'question' => $validated['question'] ?? null,
            'options' => !empty($cleanOptions) ? $cleanOptions : null,
            'correct_answer' => $validated['correct_answer'] ?? (!empty($cleanOptions[0]) ? $cleanOptions[0] : null),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $quiz = Quiz::create($data);

        // Also create a question and options if question & options provided
        if (!empty($validated['question']) && !empty($cleanOptions)) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'category_id' => $quiz->category_id,
                'user_id' => $quiz->user_id,
                'question_text' => $validated['question'],
                'explanation' => 'Answer verified by system administrator.',
                'difficulty' => $quiz->difficulty,
                'points' => 100,
                'order' => 1,
            ]);

            $correctAnswer = $validated['correct_answer'] ?? $cleanOptions[0];
            foreach ($cleanOptions as $idx => $optText) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optText,
                    'is_correct' => ($optText === $correctAnswer || $idx === 0 && empty($validated['correct_answer'])),
                    'order' => $idx + 1,
                ]);
            }
        }

        AuditService::log('quiz_created', 'info', 'Quiz', $quiz->id);

        return redirect()->route('admin.quizzes.index')
            ->with('success', "Quiz '{$quiz->title}' created successfully.");
    }

    /**
     * Admin: Show edit quiz form
     */
    public function edit(Quiz $quiz)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.quizzes.edit', compact('quiz', 'categories'));
    }

    /**
     * Admin: Update quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'time_limit_per_question' => ['nullable', 'integer', 'min:5', 'max:120'],
            'question' => ['nullable', 'string'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable', 'string'],
            'correct_answer' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $cleanOptions = [];
        if (!empty($validated['options']) && is_array($validated['options'])) {
            $cleanOptions = array_values(array_filter(array_map('trim', $validated['options'])));
        }

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'difficulty' => $validated['difficulty'],
            'time_limit_per_question' => $validated['time_limit_per_question'] ?? $quiz->time_limit_per_question,
            'question' => $validated['question'] ?? $quiz->question,
            'options' => !empty($cleanOptions) ? $cleanOptions : $quiz->options,
            'correct_answer' => $validated['correct_answer'] ?? $quiz->correct_answer,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $quiz->update($data);

        AuditService::log('quiz_updated', 'info', 'Quiz', $quiz->id);

        return redirect()->route('admin.quizzes.index')
            ->with('success', "Quiz '{$quiz->title}' updated successfully.");
    }

    /**
     * Admin: Delete quiz
     */
    public function destroy(Quiz $quiz)
    {
        $title = $quiz->title;
        $quiz->delete();

        AuditService::log('quiz_deleted', 'warning', 'Quiz', $quiz->id);

        return redirect()->route('admin.quizzes.index')
            ->with('success', "Quiz '{$title}' deleted successfully.");
    }

    /**
     * Frontend: Play Quiz at /quiz or /quiz/{id}
     */
    public function playFrontend(Request $request, $id = null)
    {
        if ($id) {
            $quiz = Quiz::where(function ($q) use ($id) {
                    $q->where('id', $id)->orWhere('slug', $id);
                })
                ->where('is_published', true)
                ->with(['category', 'questions.options'])
                ->firstOrFail();

            return view('pages.player.quiz_play', compact('quiz'));
        }

        // /quiz index: showcase playable quizzes
        $quizzes = Quiz::where('is_published', true)
            ->with(['category', 'creator'])
            ->withCount('questions')
            ->orderByDesc('plays_count')
            ->paginate(9);

        $categories = Category::where('is_active', true)->withCount('quizzes')->get();

        return view('pages.player.quiz_index', compact('quizzes', 'categories'));
    }

    /**
     * Frontend: Submit Quiz Answer & Score Calculation
     */
    public function submitFrontend(Request $request, Quiz $quiz)
    {
        $selectedAnswer = $request->input('selected_answer');
        $isCorrect = false;

        if ($quiz->correct_answer && $selectedAnswer) {
            $isCorrect = (trim(strtolower($selectedAnswer)) === trim(strtolower($quiz->correct_answer)));
        }

        $points = $isCorrect ? ($quiz->xp_reward ?? 150) : 25;

        // Increment play count
        $quiz->increment('plays_count');

        if (Auth::check()) {
            $user = Auth::user();
            $user->increment('xp', $points);
            $user->increment('coins', $isCorrect ? 10 : 2);
        }

        return response()->json([
            'is_correct' => $isCorrect,
            'correct_answer' => $quiz->correct_answer,
            'points_earned' => $points,
            'feedback' => $isCorrect ? 'Outstanding! Correct answer.' : 'Incorrect. Study the breakdown to master this concept.',
        ]);
    }
}
