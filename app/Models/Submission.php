<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'title',
        'message',
        'file_path',
        'original_filename',
        'submitted_at',
        'status',
        'marks',
        'feedback',
        'graded_at',
        'graded_by'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime'
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function isLate(): bool
    {
        return $this->submitted_at > $this->assignment->due_date;
    }

    public function getGradePercentage(): float
    {
        if (!$this->marks || !$this->assignment->max_marks) {
            return 0;
        }
        
        return ($this->marks / $this->assignment->max_marks) * 100;
    }
}
