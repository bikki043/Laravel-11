<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ตรวจสอบว่ามีบรรทัดนี้
use Barryvdh\DomPDF\Facade\Pdf; // ตรวจสอบว่ามีบรรทัดนี้

class PDFController extends Controller
{
    public function index()
    {
        // ดึงข้อมูล 35 คนต่อหน้า
        $users = User::orderBy('id')->paginate(35);

        return view('index', compact('users'))
                ->with('i', (request()->input('page', 1) - 1) * 35); // เปลี่ยนเลข 5 เป็น 35 ให้ตรงกับ paginate
    }

    public function generatePDF()
    {
        // ดึงข้อมูลทั้งหมดมาลง PDF
        $users = User::all(); 
        
        $data = [
            'date' => date('d/m/Y'),
            'users' => $users
        ];

        // ตรวจสอบว่าไฟล์ View ชื่อ 'pdf.blade.php' อยู่ใน resources/views/
        $pdf = Pdf::loadView('pdf', $data)
            ->setOptions([
                'defaultFont' => 'THSarabunNew', 
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => public_path(), 
            ]);

        return $pdf->stream('system_users_list.pdf');
    }
}