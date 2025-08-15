<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Result;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Assignment::class => \App\Policies\AssignmentPolicy::class,
        Submission::class => \App\Policies\SubmissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Assignment Policies
        Gate::define('create-assignment', function (User $user) {
            return $user->isAdminOrTeacher();
        });

        Gate::define('update-assignment', function (User $user, Assignment $assignment) {
            return $user->isAdminOrTeacher() && ($user->isAdmin() || $assignment->created_by === $user->id);
        });

        Gate::define('delete-assignment', function (User $user, Assignment $assignment) {
            return $user->isAdminOrTeacher() && ($user->isAdmin() || $assignment->created_by === $user->id);
        });

        // Submission Policies
        Gate::define('grade-submission', function (User $user) {
            return $user->isAdminOrTeacher();
        });

        Gate::define('bulk-grade-submissions', function (User $user) {
            return $user->isAdminOrTeacher();
        });

        // Result Policies
        Gate::define('create-result', function (User $user) {
            return $user->isAdminOrTeacher();
        });

        Gate::define('update-result', function (User $user, Result $result) {
            return $user->isAdminOrTeacher();
        });

        Gate::define('delete-result', function (User $user, Result $result) {
            return $user->isAdminOrTeacher();
        });

        // Student Management
        Gate::define('manage-students', function (User $user) {
            return $user->isAdminOrTeacher();
        });
    }
}
