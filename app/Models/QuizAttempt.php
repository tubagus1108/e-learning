<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'student_id',
        'started_at',
        'submitted_at',
        'score',
        'total_questions',
        'correct_answers',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'score' => 'integer',
            'total_questions' => 'integer',
            'correct_answers' => 'integer',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function isPassed(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->score >= $this->quiz->passing_score,
        );
    }

    public function percentageScore(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_questions > 0
                ? round(($this->correct_answers / $this->total_questions) * 100, 2)
                : 0,
        );
    }

    public function calculateScore(): void
    {
        $totalScore = 0;
        $correctCount = 0;

        foreach ($this->answers as $answer) {
            if ($answer->is_correct) {
                $totalScore += $answer->question->points;
                $correctCount++;
            }
        }

        $this->update([
            'score' => $totalScore,
            'correct_answers' => $correctCount,
            'total_questions' => $this->answers()->count(),
        ]);
    }
}
