<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder updates existing user passwords to simple ones for testing.
     */
    public function run(): void
    {
        // Update Admin password
        $admin = User::where('email', 'admin@diu.edu.bd')->first();
        if ($admin) {
            $admin->update(['password' => Hash::make('admin')]);
            $this->command->info('Admin password updated to: admin');
        }

        // Update Teacher password
        $teacher = User::where('email', 'teacher@diu.edu.bd')->first();
        if ($teacher) {
            $teacher->update(['password' => Hash::make('teacher')]);
            $this->command->info('Teacher password updated to: teacher');
        }

        // Update Student passwords
        $alice = User::where('email', 'alice@student.diu.edu.bd')->first();
        if ($alice) {
            $alice->update(['password' => Hash::make('alice')]);
            $this->command->info('Alice password updated to: alice');
        }

        $bob = User::where('email', 'bob@student.diu.edu.bd')->first();
        if ($bob) {
            $bob->update(['password' => Hash::make('bob')]);
            $this->command->info('Bob password updated to: bob');
        }

        $carol = User::where('email', 'carol@student.diu.edu.bd')->first();
        if ($carol) {
            $carol->update(['password' => Hash::make('carol')]);
            $this->command->info('Carol password updated to: carol');
        }

        // Update all other users to simple passwords
        $otherUsers = User::whereNotIn('email', [
            'admin@diu.edu.bd',
            'teacher@diu.edu.bd',
            'alice@student.diu.edu.bd',
            'bob@student.diu.edu.bd',
            'carol@student.diu.edu.bd'
        ])->get();

        foreach ($otherUsers as $user) {
            // Use first name as password (lowercase)
            $firstName = strtolower(explode(' ', $user->name)[0]);
            $user->update(['password' => Hash::make($firstName)]);
            $this->command->info("Updated {$user->name} password to: {$firstName}");
        }

        $this->command->info('All passwords have been simplified for testing!');
    }
}
