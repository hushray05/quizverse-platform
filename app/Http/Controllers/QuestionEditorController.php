<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionEditorController extends Controller
{
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $quizzes = Quiz::where('user_id', Auth::id())->get();

        return view('pages.creator.questions.editor', [
            'question' => null,
            'categories' => $categories,
            'quizzes' => $quizzes,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_text' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'quiz_id' => ['nullable', 'exists:quizzes,id'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'points' => ['required', 'integer', 'min:5', 'max:100'],
            'explanation' => ['nullable', 'string'],
            'options' => ['required', 'array', 'min:2', 'max:6'],
            'options.*' => ['required', 'string'],
            'correct_option_index' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($data) {
            $question = Question::create([
                'category_id' => $data['category_id'],
                'user_id' => Auth::id(),
                'quiz_id' => $data['quiz_id'] ?? null,
                'question_text' => $data['question_text'],
                'question_type' => count($data['options']) === 2 ? 'true_false' : 'multiple_choice',
                'explanation' => $data['explanation'] ?? null,
                'points' => $data['points'],
                'difficulty' => $data['difficulty'],
            ]);

            foreach ($data['options'] as $index => $optionText) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => ((int) $data['correct_option_index'] === (int) $index),
                    'order' => $index,
                ]);
            }

            AuditService::log('question_created', 'info', 'Question', $question->id);
        });

        return redirect()->route('creator.questions.index')
            ->with('success', 'Question engineered and saved to Question Bank.');
    }

    public function edit(Question $question)
    {
        if ($question->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->get();
        $quizzes = Quiz::where('user_id', Auth::id())->get();
        $question->load('options');

        return view('pages.creator.questions.editor', [
            'question' => $question,
            'categories' => $categories,
            'quizzes' => $quizzes,
        ]);
    }

    public function update(Request $request, Question $question)
    {
        if ($question->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'question_text' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'quiz_id' => ['nullable', 'exists:quizzes,id'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'points' => ['required', 'integer', 'min:5', 'max:100'],
            'explanation' => ['nullable', 'string'],
            'options' => ['required', 'array', 'min:2', 'max:6'],
            'options.*' => ['required', 'string'],
            'correct_option_index' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($question, $data) {
            $question->update([
                'category_id' => $data['category_id'],
                'quiz_id' => $data['quiz_id'] ?? null,
                'question_text' => $data['question_text'],
                'question_type' => count($data['options']) === 2 ? 'true_false' : 'multiple_choice',
                'explanation' => $data['explanation'] ?? null,
                'points' => $data['points'],
                'difficulty' => $data['difficulty'],
            ]);

            // Replace options
            $question->options()->delete();
            foreach ($data['options'] as $index => $optionText) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => ((int) $data['correct_option_index'] === (int) $index),
                    'order' => $index,
                ]);
            }

            AuditService::log('question_updated', 'info', 'Question', $question->id);
        });

        return redirect()->route('creator.questions.index')
            ->with('success', 'Question modifications synchronized.');
    }
}
