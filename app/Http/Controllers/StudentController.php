<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function index()
    {
        // ปรับให้ดึงข้อมูลธรรมดา (ถ้าไม่ได้เชื่อม User) หรือใช้ paginate ตามเดิม
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        // 1. แก้ไข Validation: เอา student_id ออก และเพิ่ม email กับ image
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email', // ตรวจสอบอีเมลไม่ให้ซ้ำ
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. จัดการเรื่องรูปภาพ (ถ้ามีการอัปโหลด)
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'เพิ่มข้อมูลนักเรียนเรียบร้อยแล้ว');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // 1. แก้ไข Validation เหมือนตอน store (ยกเว้นเรื่องอีเมลซ้ำของตัวเอง)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. จัดการรูปภาพใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่า (ถ้ามี)
            if ($student->image && File::exists(public_path('images/' . $student->image))) {
                File::delete(public_path('images/' . $student->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $student->update($validated);

        return redirect()->route('students.show', $student)->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(Student $student)
    {
        // ลบรูปภาพออกจากโฟลเดอร์ก่อนลบข้อมูลใน DB
        if ($student->image && File::exists(public_path('images/' . $student->image))) {
            File::delete(public_path('images/' . $student->image));
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'ลบข้อมูลนักเรียนเรียบร้อยแล้ว');
    }
}