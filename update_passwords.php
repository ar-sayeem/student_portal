<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require_once __DIR__ . '/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Updating user passwords to simple ones...\n\n";

// Define simple passwords for each user
$passwordUpdates = [
    'admin@diu.edu.bd' => 'admin',
    'teacher@diu.edu.bd' => 'teacher', 
    'alice@student.diu.edu.bd' => 'alice',
    'bob@student.diu.edu.bd' => 'bob',
    'carol@student.diu.edu.bd' => 'carol'
];

foreach ($passwordUpdates as $email => $password) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->update(['password' => Hash::make($password)]);
        echo "✅ Updated {$user->name} ({$email}) password to: {$password}\n";
    } else {
        echo "❌ User not found: {$email}\n";
    }
}

// Update any other users to use their first name as password
$otherUsers = User::whereNotIn('email', array_keys($passwordUpdates))->get();
foreach ($otherUsers as $user) {
    $firstName = strtolower(trim(explode(' ', $user->name)[0]));
    $user->update(['password' => Hash::make($firstName)]);
    echo "✅ Updated {$user->name} ({$user->email}) password to: {$firstName}\n";
}

echo "\n🎉 All passwords have been simplified!\n";
echo "\n📋 Login Credentials:\n";
echo "Admin: admin@diu.edu.bd / admin\n";
echo "Teacher: teacher@diu.edu.bd / teacher\n";
echo "Alice (Student): alice@student.diu.edu.bd / alice\n";
echo "Bob (Student): bob@student.diu.edu.bd / bob\n";
echo "Carol (Student): carol@student.diu.edu.bd / carol\n";

?>
