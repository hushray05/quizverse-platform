<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'mode',
        'score',
        'total_questions',
        'correct_answers',
        'xp_earned',
        'accuracy_percentage',
        'time_taken_seconds',
        'streak_count',
        'answers_summary',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'total_questions' => 'integer',
            'correct_answers' => 'integer',
            'xp_earned' => 'integer',
            'accuracy_percentage' => 'float',
            'time_taken_seconds' => 'integer',
            'streak_count' => 'integer',
            'answers_summary' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
