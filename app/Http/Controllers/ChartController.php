<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ChartController extends Controller
{
    public function index()
    {
        // 1. ดึงข้อมูลจำนวน User แยกตามเดือนในปี 2026
        $data = User::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("COUNT(*) as count")
        )
            ->whereYear('created_at', '2026')
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy('month')
            ->get();

        // 2. เตรียม Array 12 เดือน ให้มีค่าเริ่มต้นเป็น 0
        $monthsData = array_fill(1, 12, 0);

        // 3. เอาข้อมูลจาก DB มาใส่ในเดือนที่ตรงกัน
        foreach ($data as $row) {
            $monthsData[(int)$row->month] = (int)$row->count;
        }

        // 4. แปลงเป็น Array สำหรับส่งให้ Highcharts ในหน้า chart.blade.php
        $usersCount = array_values($monthsData);

        $totalUsers = User::count();

        // ใช้ paginate เพื่อให้หน้าเว็บไม่ยาวเกินไป (รองรับข้อมูล 500 คน)
        $allUsers = User::orderBy('created_at', 'desc')->paginate(10);

        return view('chart', compact('usersCount', 'totalUsers', 'allUsers'));
    }

    public function exportPDF()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Member List Report',
            'date' => date('d/m/Y H:i'),
            'users' => $users,
            'totalUsers' => $users->count()
        ];

        // ถ้าไฟล์อยู่ที่ resources/views/teachers/pdf.blade.php ให้ใช้ 'teachers.pdf'
        // ถ้าไฟล์อยู่ที่ resources/views/pdf.blade.php ให้ใช้ 'pdf'
        // เปลี่ยนจาก 'pdf' เป็น 'teachers.pdf'
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('teachers.pdf', $data)
            ->setOptions([
                'defaultFont' => 'THSarabunNew',
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
            ])
            ->stream('dashboard-report.pdf');
    }
}
