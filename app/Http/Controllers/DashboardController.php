<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalUsers = User::count();
        $totalProfiles = Profile::count();

        $recentStudents = Student::latest()->take(5)->get();
        $recentTeachers = Teacher::latest()->take(5)->get();

        return view('dashboard', [
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalUsers' => $totalUsers,
            'totalProfiles' => $totalProfiles,
            'recentStudents' => $recentStudents,
            'recentTeachers' => $recentTeachers,
        ]);
    }
}
