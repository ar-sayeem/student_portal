# 📁 Migration Files - Simple Reference Guide

## 🎯 **What Each Migration Does (in Simple Terms)**

### **Core Laravel Tables (Don't Touch These)**
- `0001_01_01_000000_create_users_table.php` → **USERS TABLE** (Main user accounts)
- `0001_01_01_000001_create_cache_table.php` → **CACHE TABLE** (System cache)  
- `0001_01_01_000002_create_jobs_table.php` → **JOBS TABLE** (Background tasks)

### **Student Portal Features**
- `2025_07_26_000001_add_role_to_users_table.php` → **USER ROLES** (admin, teacher, student)
- `2025_07_26_000002_create_assignments_table.php` → **ASSIGNMENTS** (homework, projects)
- `2025_07_26_000003_create_submissions_table.php` → **SUBMISSIONS** (student work)
- `2025_07_26_000004_create_results_table.php` → **RESULTS** (grades, scores)
- `2025_07_26_000005_create_messages_table.php` → **MESSAGES** (notifications)

### **Duplicates (Can be deleted)**
- `2025_07_26_032656_add_role_to_users_table.php` → **DUPLICATE** ❌
- `2025_07_26_032657_add_role_to_users_table.php` → **DUPLICATE** ❌
- `2025_07_28_001546_create_student_portal_tables.php` → **EMPTY** ❌

---

## 🚀 **For Future: How to Create Simple Migration Names**

When you need new migrations, use these simple commands:

```bash
# For new tables
php artisan make:migration create_courses_table
php artisan make:migration create_teachers_table  
php artisan make:migration create_students_table

# For adding columns
php artisan make:migration add_phone_to_users
php artisan make:migration add_photo_to_users

# For updates
php artisan make:migration update_user_roles
php artisan make:migration modify_assignments_table
```

## 📋 **Quick Database Overview**

**Your Student Portal has these tables:**
1. **users** → All people (students, teachers, admin)
2. **assignments** → Homework and projects  
3. **submissions** → Student work submitted
4. **results** → Grades and scores
5. **messages** → Notifications and announcements

**Note:** The timestamp prefix (2025_07_26_) is required by Laravel but focus on the descriptive part after it!
