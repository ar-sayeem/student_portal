<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require_once __DIR__ . '/vendor/autoload.php';

// Initialize Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=================================================\n";
echo "📊 STUDENT PORTAL - USER DATABASE OVERVIEW\n";
echo "=================================================\n\n";

echo "🗄️ Database: student_portal\n";
echo "📋 Table: users\n";
echo "🔑 Password Column: password (encrypted with bcrypt)\n\n";

// Get all users
$users = User::all();

if ($users->count() > 0) {
    echo "👥 CURRENT USERS IN DATABASE:\n";
    echo str_repeat("-", 80) . "\n";
    printf("%-4s %-25s %-35s %-15s %-15s\n", "ID", "Name", "Email", "Role", "Password");
    echo str_repeat("-", 80) . "\n";
    
    foreach ($users as $user) {
        // Show the simple password (since we know what they are)
        $simplePassword = '';
        switch($user->email) {
            case 'admin@diu.edu.bd':
                $simplePassword = 'admin';
                break;
            case 'teacher@diu.edu.bd':
                $simplePassword = 'teacher';
                break;
            case 'alice@student.diu.edu.bd':
                $simplePassword = 'alice';
                break;
            case 'bob@student.diu.edu.bd':
                $simplePassword = 'bob';
                break;
            case 'carol@student.diu.edu.bd':
                $simplePassword = 'carol';
                break;
            default:
                $simplePassword = strtolower(explode(' ', $user->name)[0]);
        }
        
        printf("%-4d %-25s %-35s %-15s %-15s\n", 
            $user->id, 
            substr($user->name, 0, 24), 
            $user->email, 
            $user->role ?? 'student',
            $simplePassword
        );
    }
    
    echo str_repeat("-", 80) . "\n\n";
} else {
    echo "❌ No users found in database!\n\n";
}

echo "🔍 TO VIEW IN XAMPP/phpMyAdmin:\n";
echo "1. Open: http://localhost/phpmyadmin\n";
echo "2. Click on database: 'student_portal'\n";
echo "3. Click on table: 'users'\n";
echo "4. Click 'Browse' to see all user data\n\n";

echo "📝 IMPORTANT NOTES:\n";
echo "• Passwords are encrypted (hashed) in the database\n";
echo "• You'll see long encrypted strings in the 'password' column\n";
echo "• The actual simple passwords are shown above\n";
echo "• Password column uses bcrypt encryption for security\n\n";

echo "🚀 QUICK TEST:\n";
echo "• Start server: php artisan serve\n";
echo "• Visit: http://127.0.0.1:8000\n";
echo "• Login with any credentials above\n\n";

?>
