<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class QuizService
{
    /**
     * Calculate score based on:
     * basePoints + timeBonus + streakMultiplier
     */
    public function calculateScore(int $basePoints, int $secondsRemaining, int $timeLimit, int $currentStreak): int
    {
        $timeRatio = $timeLimit > 0 ? max(0, min(1, $secondsRemaining / $timeLimit)) : 0;
        $timeBonus = (int) round($basePoints * 0.5 * $timeRatio);
        
        $streakMultiplier = match (true) {
            $currentStreak >= 5 => 1.5,
            $currentStreak >= 3 => 1.25,
            $currentStreak >= 2 => 1.1,
            default => 1.0,
        };

        return (int) round(($basePoints + $timeBonus) * $streakMultiplier);
    }

    /**
     * Process complete quiz attempt submission.
     */
    public function processAttempt(User $user, Quiz $quiz, array $submittedAnswers, string $mode = 'standard'): QuizAttempt
    {
        return DB::transaction(function () use ($user, $quiz, $submittedAnswers, $mode) {
            $questions = $quiz->questions()->with('options')->get();
            $totalQuestions = $questions->count();
            $correctCount = 0;
            $totalScore = 0;
            $currentStreak = 0;
            $maxStreak = 0;
            $totalTimeTaken = 0;
            $summary = [];

            foreach ($questions as $index => $question) {
                $answerData = $submittedAnswers[$question->id] ?? null;
                $selectedOptionId = $answerData['selected_option_id'] ?? null;
                $timeTaken = (int) ($answerData['time_taken'] ?? 5);
                $totalTimeTaken += $timeTaken;

                $correctOption = $question->options->firstWhere('is_correct', true);
                $isCorrect = $correctOption && ($selectedOptionId == $correctOption->id);

                $questionPoints = 0;
                if ($isCorrect) {
                    $correctCount++;
                    $currentStreak++;
                    if ($currentStreak > $maxStreak) {
                        $maxStreak = $currentStreak;
                    }
                    $secondsRemaining = max(0, $quiz->time_limit_per_question - $timeTaken);
                    $questionPoints = $this->calculateScore($question->points, $secondsRemaining, $quiz->time_limit_per_question, $currentStreak);
                    $totalScore += $questionPoints;
                } else {
                    $currentStreak = 0;
                }

                $summary[] = [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'selected_option_id' => $selectedOptionId,
                    'correct_option_id' => $correctOption ? $correctOption->id : null,
                    'is_correct' => $isCorrect,
                    'points_earned' => $questionPoints,
                    'time_taken' => $timeTaken,
                    'explanation' => $question->explanation,
                ];
            }

            $accuracy = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 0.0;
            
            // Calculate XP Earned
            $baseXp = $quiz->xp_reward;
            $accuracyFactor = $accuracy / 100;
            $streakBonus = $maxStreak * 10;
            $xpEarned = (int) round(($baseXp * $accuracyFactor) + $streakBonus);

            // Record attempt
            $attempt = QuizAttempt::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'mode' => $mode,
                'score' => $totalScore,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctCount,
                'xp_earned' => $xpEarned,
                'accuracy_percentage' => $accuracy,
                'time_taken_seconds' => $totalTimeTaken,
                'streak_count' => $maxStreak,
                'answers_summary' => $summary,
                'completed_at' => now(),
            ]);

            // Update user stats and level progression
            $newXp = $user->xp + $xpEarned;
            $newLevel = (int) floor(1 + sqrt($newXp / 100));
            $newStreak = ($accuracy >= 70) ? $user->streak + 1 : max(0, $user->streak);

            $user->update([
                'xp' => $newXp,
                'level' => $newLevel,
                'streak' => $newStreak,
                'coins' => $user->coins + (int) round($totalScore / 10),
                'last_active_at' => now(),
            ]);

            // Increment quiz plays count
            $quiz->increment('plays_count');

            return $attempt;
        });
    }
}
