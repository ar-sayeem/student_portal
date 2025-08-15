<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require_once __DIR__ . '/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Checking current users in database...\n\n";

try {
    // Check if users exist
    $users = User::all();
    
    if ($users->count() == 0) {
        echo "❌ No users found! Creating admin user...\n";
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@diu.edu.bd',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'department' => 'Computer Science & Engineering',
            'email_verified_at' => now(),
        ]);
        
        echo "✅ Admin user created successfully!\n";
    } else {
        echo "📊 Found {$users->count()} users:\n";
        echo "------------------------------------\n";
        
        foreach ($users as $user) {
            echo "👤 {$user->name} ({$user->email}) - Role: {$user->role}\n";
        }
    }
    
    // Test admin login specifically
    echo "\n🔐 Testing admin login...\n";
    $admin = User::where('email', 'admin@diu.edu.bd')->first();
    
    if ($admin) {
        // Update admin password to ensure it's correct
        $admin->update(['password' => Hash::make('admin')]);
        echo "✅ Admin password updated to 'admin'\n";
        
        // Test the password
        if (Hash::check('admin', $admin->password)) {
            echo "✅ Password verification successful!\n";
        } else {
            echo "❌ Password verification failed!\n";
        }
    } else {
        echo "❌ Admin user not found!\n";
    }
    
    echo "\n🚀 Try logging in now with:\n";
    echo "📧 Email: admin@diu.edu.bd\n";
    echo "🔑 Password: admin\n";
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    echo "💡 Make sure XAMPP MySQL is running!\n";
}

?>
