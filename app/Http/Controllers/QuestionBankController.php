<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionBankController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $quizzes = Quiz::where('user_id', Auth::id())->get();

        $query = Question::where('user_id', Auth::id())
            ->with(['category', 'quiz', 'options']);

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('question_text', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->input('quiz_id'));
        }

        $questions = $query->latest()->paginate(10)->withQueryString();

        return view('pages.creator.questions.index', compact('questions', 'categories', 'quizzes'));
    }

    public function destroy(Question $question)
    {
        if ($question->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $question->delete();
        AuditService::log('question_deleted', 'warning', 'Question', $question->id);

        return back()->with('success', 'Question purged from your bank.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return back()->with('error', 'No questions selected for bulk deletion.');
        }

        $count = Question::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->delete();

        AuditService::log('questions_bulk_deleted', 'warning', 'Question', null, ['count' => $count]);

        return back()->with('success', "{$count} questions purged successfully.");
    }
}
