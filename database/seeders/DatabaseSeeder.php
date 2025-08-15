<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@diu.edu.bd',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'department' => 'Computer Science & Engineering',
        ]);

        // Create Teacher User
        User::create([
            'name' => 'Dr. John Doe',
            'email' => 'teacher@diu.edu.bd',
            'password' => Hash::make('teacher'),
            'role' => 'teacher',
            'department' => 'Computer Science & Engineering',
            'phone' => '+880-1234567890',
        ]);

        // Create Sample Students
        User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@student.diu.edu.bd',
            'password' => Hash::make('alice'),
            'role' => 'student',
            'student_id' => 'CSE-2021-001',
            'department' => 'Computer Science & Engineering',
            'session' => 'Spring 2021',
            'semester' => 8,
            'phone' => '+880-1111111111',
            'address' => 'Dhaka, Bangladesh',
        ]);

        User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@student.diu.edu.bd',
            'password' => Hash::make('bob'),
            'role' => 'student',
            'student_id' => 'CSE-2021-002',
            'department' => 'Computer Science & Engineering',
            'session' => 'Spring 2021',
            'semester' => 8,
            'phone' => '+880-2222222222',
            'address' => 'Chittagong, Bangladesh',
        ]);

        User::create([
            'name' => 'Carol Williams',
            'email' => 'carol@student.diu.edu.bd',
            'password' => Hash::make('carol'),
            'role' => 'student',
            'student_id' => 'CSE-2021-003',
            'department' => 'Computer Science & Engineering',
            'session' => 'Spring 2021',
            'semester' => 8,
            'phone' => '+880-3333333333',
            'address' => 'Sylhet, Bangladesh',
        ]);

        // Call other seeders
        $this->call([
            AssignmentSeeder::class,
            ResultSeeder::class,
        ]);
    }
}
