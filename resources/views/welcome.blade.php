<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Portal - Daffodil International University</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 50px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .logo {
            margin-bottom: 15px;
            animation: bounce 2s infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .logo img {
            width: 120px;
            height: 120px;
            max-width: 140px;
            max-height: 140px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        .university-name {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .department-name {
            color: #718096;
            font-size: 1rem;
            margin-bottom: 30px;
        }
        
        .welcome-text {
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }
        
        .btn-secondary {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #38a169, #2f855a);
        }
        
        .logout-form {
            display: inline;
        }
        
        .logout-form .btn {
            background: none;
            border: 2px solid #e2e8f0;
        }
        
        .footer {
            color: #a0aec0;
            font-size: 0.9rem;
            margin-top: 20px;
        }
        
        .features {
            display: flex;
            justify-content: space-around;
            margin: 25px 0;
            padding: 20px 0;
            border-top: 1px solid #e2e8f0;
        }
        
        .feature {
            text-align: center;
            flex: 1;
        }
        
        .feature-icon {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }
        
        .feature-text {
            font-size: 0.85rem;
            color: #718096;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 30px 25px;
                margin: 10px;
            }
            
            .logo img {
                width: 80px;
                height: 80px;
            }
            
            .auth-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 200px;
            }
            
            .features {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/logo1.png') }}" alt="Student Portal Logo">
        </div>
        <h1 class="university-name">Student Portal</h1>
        <div class="university-name" style="font-size: 1.2rem;">Daffodil International University</div>
        <div class="department-name">Department of Computer Science & Engineering</div>
        
        <div class="welcome-text">
            Welcome to your academic portal! Access assignments, grades, course materials, and stay connected with your academic journey.
        </div>
        
        <div class="features">
            <div class="feature">
                <div class="feature-icon">📚</div>
                <div class="feature-text">Assignments</div>
            </div>
            <div class="feature">
                <div class="feature-icon">📊</div>
                <div class="feature-text">Grades</div>
            </div>
            <div class="feature">
                <div class="feature-icon">📢</div>
                <div class="feature-text">Announcements</div>
            </div>
        </div>
        
        <div class="auth-buttons">
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Login to Portal
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary">
                    Create Account
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-success">
                    Go to Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
        
        <div class="footer">
            © {{ date('Y') }} Daffodil International University. All rights reserved.
        </div>
    </div>
</body>
</html>