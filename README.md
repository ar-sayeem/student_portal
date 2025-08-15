# 🎓 Student Portal Management System

<p align="center">
<img src="https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel" alt="Laravel 11">
<img src="https://img.shields.io/badge/PHP-8.1+-blue?style=for-the-badge&logo=php" alt="PHP 8.1+">
<img src="https://img.shields.io/badge/SQLite-Database-green?style=for-the-badge&logo=sqlite" alt="SQLite">
<img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="MIT License">
<img src="https://img.shields.io/github/last-commit/ar-sayeem/student_portal?style=for-the-badge&color=brightgreen" alt="Last Commit">
</p>

A comprehensive **Student Portal Management System** built with Laravel 11, featuring role-based authentication, assignment management, and academic tracking. This system streamlines educational workflows between administrators, teachers, and students.

## 🚀 What I Built

This project demonstrates a complete educational management platform with:

### 🔐 **Authentication & Authorization System**
- **Multi-role authentication** (Admin, Teacher, Student)
- **Secure login/logout** with session management
- **Role-based access control** using Laravel policies
- **Password security** with BCrypt hashing
- **Email-based registration** with validation

### 📚 **Core Educational Features**
- **Assignment Management**: Teachers create and distribute assignments with file uploads
- **Submission System**: Students submit assignments with file attachment support
- **Grading Interface**: Teachers grade submissions with feedback and marks
- **Results Tracking**: Comprehensive academic performance monitoring
- **Internal Messaging**: Communication system between users
- **Dashboard Analytics**: Role-specific statistics and insights

### 🛠 **Technical Implementation**
- **Clean MVC Architecture** with proper separation of concerns
- **Database Optimization**: 8-table schema optimized for performance
- **File Management**: Secure file upload/download with validation
- **UI/UX Enhancement**: Auto-dismissing notifications and responsive design
- **Performance Optimization**: File-based caching and query optimization

## 🏗 **System Architecture**

### **Technology Stack:**
- **Backend**: Laravel 11 (PHP 8.1+)
- **Database**: SQLite (MySQL compatible)
- **Frontend**: Blade Templates + Alpine.js + Tailwind CSS
- **Authentication**: Laravel Breeze + Custom RBAC
- **File Storage**: Laravel Storage with authorization
- **Caching**: File-based caching system

### **Database Schema:**
```
📊 8 Optimized Tables:
├── users (Authentication & Profiles)
├── assignments (Course Assignments)
├── submissions (Student Submissions)
├── results (Academic Results)
├── messages (Internal Communication)
├── sessions (User Sessions)
├── password_reset_tokens (Password Recovery)
└── migrations (Schema Tracking)
```

## ✨ **Key Features Implemented**

### **Role-Based Access Control:**
- 🔴 **Admin**: Full system management and oversight
- 🟡 **Teacher**: Assignment creation, grading, student management
- 🟢 **Student**: Assignment submission, result viewing, messaging

### **Educational Workflow:**
1. **Teachers** create assignments with course details and due dates
2. **Students** view assignments and submit their work with file uploads
3. **Teachers** grade submissions with marks and detailed feedback
4. **Students** receive grades and view academic progress
5. **All users** communicate through internal messaging system

### **Security Features:**
- ✅ **Input Validation**: Comprehensive form validation and sanitization
- ✅ **File Security**: Safe file upload with type and size restrictions
- ✅ **CSRF Protection**: Cross-site request forgery prevention
- ✅ **SQL Injection Prevention**: Eloquent ORM with prepared statements
- ✅ **Authorization Policies**: Fine-grained permission control

## 🚀 **Quick Start**

### **Prerequisites:**
- PHP 8.1+
- Composer
- Node.js & NPM

### **Installation:**
```bash
# 1. Clone the repository
git clone https://github.com/ar-sayeem/student_portal.git
cd student_portal

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Database setup
touch database/database.sqlite
php artisan migrate
php artisan db:seed --class=TestDataSeeder

# 5. Build assets and start server
npm run build
php artisan storage:link
php artisan serve
```

### **Access Application:**
Open your browser and navigate to: `http://127.0.0.1:8000`

## 🔑 **Test Credentials**

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| **Admin** | admin@diu.edu.bd | admin | Full system access |
| **Teacher** | teacher@diu.edu.bd | teacher | Assignment & grading management |
| **Student** | student1@diu.edu.bd | student1 | Assignment submission & results |

> **Note**: Additional student accounts available (student1-student5@diu.edu.bd)

## 📱 **What Each Role Can Do**

### **👨‍💼 Admin Dashboard:**
- Manage all users and roles
- System-wide statistics and analytics
- Full access to all assignments and submissions
- User management and account creation

### **👩‍🏫 Teacher Dashboard:**
- Create and manage assignments
- Grade student submissions
- View student performance analytics
- Communicate with students
- Manage course-specific data

### **👨‍🎓 Student Dashboard:**
- View assigned coursework
- Submit assignments with file uploads
- Track academic progress and grades
- Receive feedback from teachers
- Message teachers and administrators

## 🎯 **Technical Achievements**

### **Code Quality:**
- ✅ **PSR Standards**: PHP coding standards compliance
- ✅ **Clean Code**: Readable, maintainable code structure
- ✅ **MVC Architecture**: Proper separation of concerns
- ✅ **Error Handling**: Comprehensive error management

### **Performance:**
- ✅ **Database Optimization**: Efficient queries with eager loading
- ✅ **File-Based Caching**: Improved response times
- ✅ **Asset Optimization**: Minified CSS/JS with browser caching
- ✅ **Query Optimization**: Reduced database load

### **Security:**
- ✅ **Authentication**: Secure user authentication system
- ✅ **Authorization**: Role-based access control
- ✅ **Data Validation**: Input sanitization and validation
- ✅ **File Security**: Safe file upload and storage

## 📊 **Project Statistics**

| Component | Count | Description |
|-----------|-------|-------------|
| **Database Tables** | 8 | Optimized schema design |
| **Application Routes** | 67+ | Complete API coverage |
| **Core Models** | 5 | Full relationship mapping |
| **Controllers** | 15+ | Organized business logic |
| **Policies** | 2+ | Authorization control |
| **Middlewares** | 3+ | Request filtering |
| **Seeders** | 2 | Test data generation |

## 📁 **Project Structure**

```
student_portal/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Policies/            # Authorization policies
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database schema
│   ├── seeders/            # Test data seeders
│   └── database.sqlite     # SQLite database
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/
│   ├── web.php             # Web routes
│   └── auth.php            # Authentication routes
├── Report/                 # Project documentation
│   ├── README.md           # Documentation overview
│   ├── student_portal_report.pdf
│   ├── student_portal_report.docx
│   └── student_portal_report.html
└── storage/               # File storage
```

## 📋 **Future Enhancements**

### **Planned Features:**
- 📧 **Email Notifications**: Assignment reminders and grade alerts
- 📊 **Advanced Analytics**: Detailed performance reporting
- 📱 **Mobile API**: RESTful API for mobile app development
- 🎥 **Video Integration**: Online classes and video submissions
- 🔍 **Search Functionality**: Advanced search across all modules

## 🤝 **Contributing**

This project was built as an educational demonstration. Feel free to:
- Fork the repository
- Submit issues and feature requests
- Create pull requests for improvements
- Use as a learning resource

## 📜 **License**

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 **Developer**

Built with ❤️ as a comprehensive demonstration of:
- **Laravel Framework Mastery**
- **Database Design & Optimization**
- **Authentication & Authorization Systems**
- **Educational Domain Understanding**
- **Full-Stack Web Development**

---

**🎯 This project showcases a complete educational management solution, demonstrating enterprise-level development practices and modern web application architecture.**
