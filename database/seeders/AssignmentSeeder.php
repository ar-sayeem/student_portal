<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::where('role', 'teacher')->first();

        Assignment::create([
            'title' => 'Web Engineering Project - E-commerce Website',
            'description' => 'Create a complete e-commerce website using Laravel framework. The website should include user authentication, product catalog, shopping cart, and payment integration. Submit the complete source code and documentation.',
            'course_code' => 'CSE-4108',
            'course_name' => 'Web Engineering',
            'due_date' => now()->addDays(14),
            'max_marks' => 100,
            'created_by' => $teacher->id,
        ]);

        Assignment::create([
            'title' => 'Database Management System Design',
            'description' => 'Design and implement a database management system for a university student portal. Include ER diagrams, normalization, and SQL queries. Submit both theoretical documentation and practical implementation.',
            'course_code' => 'CSE-3108',
            'course_name' => 'Database Management System',
            'due_date' => now()->addDays(21),
            'max_marks' => 80,
            'created_by' => $teacher->id,
        ]);

        Assignment::create([
            'title' => 'Data Structures & Algorithms Implementation',
            'description' => 'Implement various data structures (Stack, Queue, Binary Tree, Graph) and algorithms (Sorting, Searching) in C++. Provide time complexity analysis for each implementation.',
            'course_code' => 'CSE-2108',
            'course_name' => 'Data Structures & Algorithms',
            'due_date' => now()->addDays(7),
            'max_marks' => 90,
            'created_by' => $teacher->id,
        ]);

        Assignment::create([
            'title' => 'Software Engineering Documentation',
            'description' => 'Create comprehensive software documentation including SRS, Design Document, Test Cases, and User Manual for a mobile application project.',
            'course_code' => 'CSE-3208',
            'course_name' => 'Software Engineering',
            'due_date' => now()->addDays(28),
            'max_marks' => 75,
            'created_by' => $teacher->id,
        ]);
    }
}
