<?php

namespace Database\Seeders;

use App\Models\Result;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {
            // Web Engineering Results
            Result::create([
                'student_id' => $student->id,
                'course_code' => 'CSE-4108',
                'course_name' => 'Web Engineering',
                'semester' => 'Summer 2025',
                'exam_type' => 'Midterm',
                'marks_obtained' => rand(65, 95),
                'total_marks' => 100,
                'grade' => 'A',
                'gpa' => 3.75,
                'exam_date' => now()->subDays(30),
                'uploaded_by' => $admin->id,
            ]);

            // Database Management System Results
            Result::create([
                'student_id' => $student->id,
                'course_code' => 'CSE-3108',
                'course_name' => 'Database Management System',
                'semester' => 'Summer 2025',
                'exam_type' => 'Assignment',
                'marks_obtained' => rand(70, 90),
                'total_marks' => 80,
                'grade' => 'A-',
                'gpa' => 3.50,
                'exam_date' => now()->subDays(15),
                'uploaded_by' => $admin->id,
            ]);

            // Data Structures Results
            Result::create([
                'student_id' => $student->id,
                'course_code' => 'CSE-2108',
                'course_name' => 'Data Structures & Algorithms',
                'semester' => 'Summer 2025',
                'exam_type' => 'Quiz',
                'marks_obtained' => rand(75, 90),
                'total_marks' => 90,
                'grade' => 'B+',
                'gpa' => 3.25,
                'exam_date' => now()->subDays(7),
                'uploaded_by' => $admin->id,
            ]);
        }
    }
}
