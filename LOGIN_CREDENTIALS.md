# Student Portal - Simple Login Credentials

## 🔑 Easy Login Information

The user passwords have been simplified for easy testing and development.

### Admin Account
- **Email:** admin@diu.edu.bd
- **Password:** admin
- **Role:** Administrator

### Teacher Account
- **Email:** teacher@diu.edu.bd
- **Password:** teacher
- **Role:** Teacher/Instructor

### Student Accounts

#### Alice Smith
- **Email:** alice@student.diu.edu.bd
- **Password:** alice
- **Student ID:** CSE-2021-001
- **Role:** Student

#### Bob Johnson
- **Email:** bob@student.diu.edu.bd
- **Password:** bob
- **Student ID:** CSE-2021-002
- **Role:** Student

#### Carol Williams
- **Email:** carol@student.diu.edu.bd
- **Password:** carol
- **Student ID:** CSE-2021-003
- **Role:** Student

---

## 📝 Password Pattern

- **Admin:** Uses "admin" as password
- **Teacher:** Uses "teacher" as password
- **Students:** Use their first name (lowercase) as password

## 🔄 How to Reset/Update Passwords

If you need to update passwords again:

1. **Using Database Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Using the Update Script:**
   ```bash
   php update_passwords.php
   ```

3. **Manual Update via Tinker:**
   ```bash
   php artisan tinker
   ```
   Then in tinker:
   ```php
   $user = App\Models\User::where('email', 'admin@diu.edu.bd')->first();
   $user->password = Hash::make('admin');
   $user->save();
   ```

---

## 🚀 Quick Start

1. Start the server: `php artisan serve`
2. Visit: http://127.0.0.1:8000
3. Click "Login to Portal"
4. Use any of the credentials above

**Note:** These are simplified passwords for development/testing only. In production, use strong passwords!
