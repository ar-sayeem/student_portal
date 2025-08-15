<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== TESTING ADMIN LOGIN ===\n\n";

// Check if admin exists
$admin = User::where('email', 'admin@diu.edu.bd')->first();

if ($admin) {
    echo "✅ Admin user found!\n";
    echo "📧 Email: " . $admin->email . "\n";
    echo "👤 Name: " . $admin->name . "\n";
    echo "🎭 Role: " . ($admin->role ?? 'not set') . "\n";
    
    // Test password
    echo "\n🔐 Testing password 'admin'...\n";
    if (Hash::check('admin', $admin->password)) {
        echo "✅ Password is correct!\n";
    } else {
        echo "❌ Password doesn't match. Updating it now...\n";
        $admin->update(['password' => Hash::make('admin')]);
        echo "✅ Password updated to 'admin'\n";
    }
} else {
    echo "❌ Admin user not found! Creating one now...\n";
    
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@diu.edu.bd',
        'password' => Hash::make('admin'),
        'role' => 'admin',
        'department' => 'Computer Science & Engineering',
        'email_verified_at' => now(),
    ]);
    
    echo "✅ Admin user created!\n";
}

echo "\n🚀 LOGIN CREDENTIALS:\n";
echo "📧 Email: admin@diu.edu.bd\n";
echo "🔑 Password: admin\n";
echo "\nTry logging in now!\n";

?>
