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
        // ดึงตัวเลขสถิติ
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalUsers = User::count();

        // ดึงข้อมูล Profiles แบบ Paginate (เพื่อให้หน้า View ใช้ ->total() ได้)
        $profiles = Profile::latest()->paginate(10);

        // ดึงรายการล่าสุด
        $recentStudents = Student::latest()->take(5)->get();
        $recentTeachers = Teacher::latest()->take(5)->get();

        return view('dashboard', [
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalUsers' => $totalUsers,
            'profiles' => $profiles, // *** ต้องใช้ชื่อนี้เท่านั้น เพื่อแก้ Error บรรทัด 162 ***
            'recentStudents' => $recentStudents,
            'recentTeachers' => $recentTeachers,
        ]);
    }
}
