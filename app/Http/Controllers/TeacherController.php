<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;


class TeacherController extends Controller
{
    public function index()
    {
        // ปรับให้ดึงข้อมูลธรรมดา (ถ้าไม่ได้เชื่อม User) หรือใช้ paginate ตามเดิม
        $teachers = Teacher::latest()->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        // 1. แก้ไข Validation: เอา student_id ออก และเพิ่ม email กับ image
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email', // ตรวจสอบอีเมลไม่ให้ซ้ำ
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. จัดการเรื่องรูปภาพ (ถ้ามีการอัปโหลด)
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'เพิ่มข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }



    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        // 1. แก้ไข Validation เหมือนตอน store (ยกเว้นเรื่องอีเมลซ้ำของตัวเอง)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. จัดการรูปภาพใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่า (ถ้ามี)
            if ($teacher->image && File::exists(public_path('images/' . $teacher->image))) {
                File::delete(public_path('images/' . $teacher->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $teacher->update($validated);

        return redirect()->route('teachers.show', $teacher)->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(Teacher $teacher)
    {
        // ลบรูปภาพออกจากโฟลเดอร์ก่อนลบข้อมูลใน DB
        if ($teacher->image && File::exists(public_path('images/' . $teacher->image))) {
            File::delete(public_path('images/' . $teacher->image));
        }

        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'ลบข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function exportPDF()
{
    // 1. ดึงข้อมูลครูทั้งหมด
    $teachers = Teacher::all();

    // 2. สร้าง Array ข้อมูลสำหรับส่งไปที่ Blade (ต้องมี title และ date ตามที่เขียนใน Blade)
    $data = [
        'title' => 'รายงานรายชื่อบุคลากร (LMS System)',
        'date'  => date('d/m/Y H:i'),
        'teachers' => $teachers
    ];

    // 3. โหลด View และส่ง $data ไปแทน compact('teachers')
    $pdf = Pdf::loadView('teachers.pdf', $data)
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'THSarabunNew', 
            'chroot' => public_path(), 
        ]);

    return $pdf->stream('teacher-report.pdf');
}
}
