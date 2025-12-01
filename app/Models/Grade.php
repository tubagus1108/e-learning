<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'semester',
        'academic_year',
        'midterm_score',
        'final_score',
        'total_score',
        'grade',
    ];

    protected function casts(): array
    {
        return [
            'semester' => 'integer',
            'midterm_score' => 'decimal:2',
            'final_score' => 'decimal:2',
            'total_score' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
