<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Message;
use App\Models\Result;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            return $this->studentDashboard();
        } elseif ($user->isAdminOrTeacher()) {
            return $this->adminTeacherDashboard();
        }
        
        return redirect()->route('login');
    }
    
    private function studentDashboard()
    {
        $user = Auth::user();
        
        $data = [
            'totalAssignments' => Assignment::where('is_active', true)->count(),
            'submittedAssignments' => Submission::where('student_id', $user->id)->count(),
            'pendingAssignments' => Assignment::where('is_active', true)
                ->where('due_date', '>=', now()) // Only count assignments that are not overdue
                ->whereDoesntHave('submissions', function($query) use ($user) {
                    $query->where('student_id', $user->id);
                })->count(),
            'totalResults' => Result::where('student_id', $user->id)->count(),
            'averageGPA' => Result::where('student_id', $user->id)->avg('gpa'),
            'recentAssignments' => Assignment::where('is_active', true)
                ->where('due_date', '>=', now())
                ->orderBy('due_date', 'asc')
                ->limit(5)
                ->get(),
            'recentSubmissions' => Submission::where('student_id', $user->id)
                ->with(['assignment'])
                ->orderBy('submitted_at', 'desc')
                ->limit(5)
                ->get(),
            'recentResults' => Result::where('student_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'unreadMessages' => Message::where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count(),
        ];
        
        return view('dashboard.student', compact('data'));
    }
    
    private function adminTeacherDashboard()
    {
        $data = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalAssignments' => Assignment::count(),
            'totalSubmissions' => Submission::count(),
            'pendingGrading' => Submission::where('status', 'submitted')->count(),
            'recentSubmissions' => Submission::with(['student', 'assignment'])
                ->orderBy('submitted_at', 'desc')
                ->limit(10)
                ->get(),
            'recentAssignments' => Assignment::with('creator')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'unreadMessages' => Message::where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->count(),
            'studentsPerDepartment' => User::where('role', 'student')
                ->selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->get(),
        ];
        
        return view('dashboard.admin-teacher', compact('data'));
    }
}
