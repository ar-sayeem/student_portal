<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_code',
        'course_name',
        'semester',
        'exam_type',
        'marks_obtained',
        'total_marks',
        'grade',
        'gpa',
        'remarks',
        'exam_date',
        'uploaded_by'
    ];

    protected $casts = [
        'exam_date' => 'date',
        'marks_obtained' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'gpa' => 'decimal:2'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getPercentage(): float
    {
        if (!$this->total_marks) {
            return 0;
        }
        
        return ($this->marks_obtained / $this->total_marks) * 100;
    }

    public function calculateGrade(): string
    {
        $percentage = $this->getPercentage();
        
        if ($percentage >= 80) return 'A+';
        if ($percentage >= 75) return 'A';
        if ($percentage >= 70) return 'A-';
        if ($percentage >= 65) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 55) return 'B-';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 45) return 'C';
        if ($percentage >= 40) return 'D';
        
        return 'F';
    }
}
