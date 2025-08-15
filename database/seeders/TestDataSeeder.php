<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a teacher
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@test.com'],
            [
                'name' => 'Test Teacher',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'department' => 'Computer Science',
            ]
        );

        // Create a student
        $student = User::firstOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => 'STU001',
                'department' => 'Computer Science',
                'session' => '2024-25',
                'semester' => 1,
            ]
        );

        // Create an assignment
        $assignment = Assignment::firstOrCreate(
            ['title' => 'Test Assignment'],
            [
                'description' => 'This is a test assignment for debugging.',
                'course_code' => 'CS101',
                'course_name' => 'Computer Science Fundamentals',
                'due_date' => now()->addDays(7),
                'max_marks' => 100,
                'is_active' => true,
                'created_by' => $teacher->id,
            ]
        );

        // Create a submission
        Submission::firstOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id' => $student->id,
            ],
            [
                'title' => 'My Test Submission',
                'message' => 'This is my answer to the test assignment.',
                'file_path' => 'submissions/test_file.pdf',
                'original_filename' => 'test_file.pdf',
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        echo "Test data created successfully!\n";
        echo "Teacher: teacher@test.com / password\n";
        echo "Student: student@test.com / password\n";
    }
}
