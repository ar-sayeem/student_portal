<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_code',
        'course_name',
        'due_date',
        'file_path',
        'original_filename',
        'max_marks',
        'created_by',
        'is_active'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function getSubmissionByStudent($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->first();
    }

    public function isOverdue(): bool
    {
        return $this->due_date < now();
    }
}
