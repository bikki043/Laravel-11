<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    /**
     * หน้าแรก และ ระบบค้นหา (Search)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // ปรับ Query ให้รองรับการค้นหา (Search)
        $students = Student::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('student_id', 'like', "%{$search}%")
                         ->orWhere('classroom', 'like', "%{$search}%")
                         ->orWhere('parent_name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString(); // สำคัญ: เพื่อให้ Search ไม่หายเวลาเปลี่ยนหน้า

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $lastStudent = Student::orderBy('id', 'desc')->first();
        $nextIdNumber = $lastStudent ? str_pad($lastStudent->id + 1, 3, '0', STR_PAD_LEFT) : "001";
        $nextId = "STU-" . $nextIdNumber;

        return view('students.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'         => 'required|unique:students,student_id',
            'name'               => 'required|string|max:255',
            'nickname'           => 'nullable|string|max:50',
            'email'              => 'required|email|unique:students,email',
            'gender'             => 'required',
            'birth_date'         => 'required|date',
            'classroom'          => 'required|string',
            'blood_group'        => 'nullable',
            'congenital_disease' => 'nullable',
            'allergy'            => 'nullable',
            'parent_name'        => 'required',
            'parent_phone'       => 'required',
            'address'            => 'required',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'ลงทะเบียนนักเรียนใหม่เรียบร้อยแล้ว');
    }

    /**
     * ฟังก์ชัน Edit (แก้ปัญหา Call to undefined method App\Http\Controllers\StudentController::edit)
     */
    public function edit(Student $student)
    {
        // ส่งข้อมูลนักศึกษาไปยังหน้าแก้ไข
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'nickname'           => 'nullable|string|max:50',
            'classroom'          => 'required|string',
            'blood_group'        => 'nullable',
            'congenital_disease' => 'nullable',
            'allergy'            => 'nullable',
            'parent_name'        => 'required',
            'parent_phone'       => 'required',
            'address'            => 'required',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($student->image && File::exists(public_path('images/' . $student->image))) {
                File::delete(public_path('images/' . $student->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'อัปเดตข้อมูลนักเรียนเรียบร้อยแล้ว');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        if ($student->image && File::exists(public_path('images/' . $student->image))) {
            File::delete(public_path('images/' . $student->image));
        }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'ลบข้อมูลนักเรียนเรียบร้อยแล้ว');
    }

    public function exportPDF()
    {
        $students = Student::orderBy('id', 'asc')->get();
        $data = [
            'title'    => 'Report of Student ',
            'date'     => date('d/m/Y H:i'),
            'students' => $students
        ];

        $pdf = Pdf::loadView('students.pdf_template', $data)
            ->setOptions([
                'defaultFont' => 'THSarabunNew',
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->stream('student-report.pdf');
    }
}