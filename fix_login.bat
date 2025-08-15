@echo off
echo ========================================
echo STUDENT PORTAL - LOGIN FIX
echo ========================================
echo.

echo Step 1: Clearing Laravel cache...
php artisan config:clear
php artisan route:clear
php artisan cache:clear

echo.
echo Step 2: Running database migrations...
php artisan migrate:fresh

echo.
echo Step 3: Creating admin user...
php artisan tinker --execute="App\Models\User::create(['name' => 'Admin User', 'email' => 'admin@diu.edu.bd', 'password' => Hash::make('admin'), 'role' => 'admin', 'department' => 'Computer Science & Engineering', 'email_verified_at' => now()]);"

echo.
echo Step 4: Creating student users...
php artisan db:seed

echo.
echo ========================================
echo LOGIN CREDENTIALS:
echo ========================================
echo Admin: admin@diu.edu.bd / admin
echo Teacher: teacher@diu.edu.bd / teacher  
echo Student: alice@student.diu.edu.bd / alice
echo ========================================
echo.
echo Try logging in now!
pause
