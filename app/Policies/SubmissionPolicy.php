<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubmissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view submissions
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Submission $submission): bool
    {
        // Students can only view their own submissions
        // Teachers and admins can view all submissions
        return $user->isAdminOrTeacher() || ($user->isStudent() && $submission->student_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isStudent(); // Only students can create submissions
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Submission $submission): bool
    {
        // Students can only update their own ungraded submissions before due date
        return $user->isStudent() && 
               $submission->student_id === $user->id && 
               $submission->status !== 'graded' && 
               !$submission->assignment->isOverdue();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Submission $submission): bool
    {
        return false; // No one can delete submissions
    }

    /**
     * Determine whether the user can grade the submission.
     */
    public function grade(User $user, Submission $submission): bool
    {
        return $user->isAdminOrTeacher(); // Only teachers and admins can grade
    }

    /**
     * Determine whether the user can bulk grade submissions.
     */
    public function bulkGrade(User $user): bool
    {
        return $user->isAdminOrTeacher(); // Only teachers and admins can bulk grade
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Submission $submission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Submission $submission): bool
    {
        return false;
    }
}
