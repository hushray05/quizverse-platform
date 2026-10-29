<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\AuditService;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameplayController extends Controller
{
    public function __construct(
        protected QuizService $quizService
    ) {}

    public function play(string $slug)
    {
        $quiz = Quiz::where(function ($query) use ($slug) {
                $query->where('slug', $slug)->orWhere('id', $slug);
            })
            ->where('is_published', true)
            ->with(['category', 'questions.options'])
            ->firstOrFail();

        if ($quiz->questions->isEmpty()) {
            return redirect()->route('explore')
                ->with('error', 'This quiz does not currently have active questions.');
        }

        $mode = 'standard';
        return view('pages.player.gameplay', compact('quiz', 'mode'));
    }

    public function quickPlay()
    {
        $quiz = Quiz::where('is_published', true)
            ->with(['category', 'questions.options'])
            ->has('questions')
            ->inRandomOrder()
            ->first();

        if (!$quiz) {
            return redirect()->route('explore')->with('error', 'No active quizzes found for Quick Play.');
        }

        $mode = 'quick';
        return view('pages.player.gameplay', compact('quiz', 'mode'));
    }

    public function dailyChallenge()
    {
        $quiz = Quiz::where('is_published', true)
            ->where('is_featured', true)
            ->with(['category', 'questions.options'])
            ->first();

        if (!$quiz) {
            $quiz = Quiz::where('is_published', true)->with(['category', 'questions.options'])->firstOrFail();
        }

        $mode = 'daily';
        return view('pages.player.gameplay', compact('quiz', 'mode'));
    }

    public function submitAttempt(Request $request, string $slug)
    {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Process submitted answers map: [ question_id => [ 'selected_option_id' => ..., 'time_taken' => ... ] ]
        $submittedAnswers = $request->input('answers', []);
        $mode = $request->input('mode', 'standard');

        $attempt = $this->quizService->processAttempt($user, $quiz, $submittedAnswers, $mode);

        AuditService::log('quiz_completed', 'info', 'QuizAttempt', $attempt->id, [
            'quiz' => $quiz->title,
            'score' => $attempt->score,
            'accuracy' => $attempt->accuracy_percentage,
            'xp_earned' => $attempt->xp_earned,
        ]);

        return redirect()->route('play.results', $attempt->id)
            ->with('success', "Quiz completed! +{$attempt->xp_earned} XP awarded.");
    }

    public function results(QuizAttempt $attempt)
    {
        $attempt->load(['quiz.category', 'user']);

        return view('pages.player.results', compact('attempt'));
    }
}
