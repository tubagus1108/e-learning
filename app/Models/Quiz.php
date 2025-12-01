<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'description',
        'duration_minutes',
        'max_attempts',
        'passing_score',
        'is_published',
        'start_time',
        'end_time',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'duration_minutes' => 'integer',
            'max_attempts' => 'integer',
            'passing_score' => 'integer',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function attempt(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function totalPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->questions()->sum('points'),
        );
    }

    public function isAvailable(): bool
    {
        if (! $this->is_published) {
            return false;
        }

        $now = now();

        if ($this->start_time && $now->isBefore($this->start_time)) {
            return false;
        }

        if ($this->end_time && $now->isAfter($this->end_time)) {
            return false;
        }

        return true;
    }
}
