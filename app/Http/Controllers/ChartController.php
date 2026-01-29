<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
public function index()
{
    // สถิติกราฟปี 2026
    $usersCount = User::select(DB::raw("COUNT(*) as count"))
        ->whereYear('created_at', '2026')
        ->groupBy(DB::raw("Month(created_at)"))
        ->orderBy(DB::raw("Month(created_at)"))
        ->pluck('count');

    $totalUsers = User::count();
    
    // เรียงจากสมัครล่าสุดไปเก่าสุด
    $allUsers = User::orderBy('created_at', 'desc')->get();

    return view('chart', compact('usersCount', 'totalUsers', 'allUsers'));
}
}