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
        // ดึงข้อมูลล่าสุดและแบ่งหน้า
        $teachers = Teacher::latest()->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        // ดึง ID ล่าสุดเพื่อนำมาแสดงเลขถัดไป (เช่น 001, 002)
        $lastTeacher = Teacher::orderBy('id', 'desc')->first();
        
        if (!$lastTeacher) {
            $nextId = "001";
        } else {
            $nextId = str_pad($lastTeacher->id + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('teachers.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id'      => 'required|string|unique:teachers,teacher_id',
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:teachers,email',
            'position'        => 'nullable|string|max:255',
            'department'      => 'nullable|string|max:255',
            'subject'         => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'start_date'      => 'required|date',
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'motto'           => 'nullable|string|max:255',
            'image'           => 'nullable|image|max:2048',
        ]);

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
        $validated = $request->validate([
            'teacher_id'      => 'required|string|unique:teachers,teacher_id,' . $teacher->id,
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:teachers,email,' . $teacher->id,
            'position'        => 'nullable|string|max:255',
            'department'      => 'nullable|string|max:255',
            'subject'         => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'start_date'      => 'required|date',
            'phone'           => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'motto'           => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // ลบรูปเก่าถ้ามีการอัปโหลดรูปใหม่
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
        if ($teacher->image && File::exists(public_path('images/' . $teacher->image))) {
            File::delete(public_path('images/' . $teacher->image));
        }

        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'ลบข้อมูลอาจารย์เรียบร้อยแล้ว');
    }

    public function exportPDF()
    {
        $teachers = Teacher::orderBy('id', 'asc')->get();

        $data = [
            'title'    => 'Report of Teacher ',
            'date'     => date('d/m/Y H:i'),
            'teachers' => $teachers
        ];

        $pdf = Pdf::loadView('teachers.pdf_template', $data)
            ->setOptions([
                'defaultFont' => 'THSarabunNew',
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->stream('teacher-report.pdf');
    }
}