@extends('layouts.app')

@section('title', 'จัดการข้อมูลนักศึกษา')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f4f7fe; color: #2d3748; }
    
    .mini-stat {
        background: white; padding: 10px 20px; border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;
    }

    .btn-action {
        border-radius: 12px; padding: 8px 18px; font-weight: 600;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;
    }
    
    .table-container {
        background: white; border-radius: 20px; border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02); overflow: hidden;
    }
    .student-row { transition: 0.3s; border-bottom: 1px solid #f8fafc; }
    .student-row:hover { background-color: #f8faff !important; }

    .search-wrapper {
        background: white; border-radius: 12px; border: 1px solid #e2e8f0;
        padding: 4px 12px; transition: 0.3s;
    }
    .search-wrapper:focus-within { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
    
    /* แก้ไขปุ่มเครื่องมือไม่ให้กะพริบ */
    .tool-btn {
        width: 35px; height: 35px; display: inline-flex; align-items: center; 
        justify-content: center; border-radius: 10px; transition: 0.2s;
        border: 1px solid #edf2f7; background: white;
    }
    .tool-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
</style>

<div class="container py-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3" data-aos="fade-down">
        <div>
            <h3 class="fw-bold mb-1">ทะเบียนนักศึกษา</h3>
            <div class="d-flex align-items-center gap-3">
                <span class="mini-stat small text-muted">
                    <i class="fas fa-users text-primary me-1"></i> ทั้งหมด <strong>{{ $students->total() }}</strong> คน
                </span>
            </div>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('students.pdf') }}" class="btn btn-action btn-outline-danger bg-white shadow-sm">
                <i class="fas fa-file-pdf"></i> พิมพ์ PDF
            </a>
            <a href="{{ route('students.create') }}" class="btn btn-action btn-primary border-0 shadow-sm" style="background: #4f46e5;">
                <i class="fas fa-plus-circle"></i> เพิ่มนักศึกษา
            </a>
        </div>
    </div>

    <div class="row mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="col-md-12">
            <form action="{{ route('students.index') }}" method="GET" class="d-flex gap-2">
                <div class="search-wrapper d-flex align-items-center flex-grow-1">
                    <i class="fas fa-search text-muted me-2"></i>
                    <input type="text" name="search" class="form-control border-0 shadow-none" 
                           placeholder="ค้นหารหัส, ชื่อ, ชั้นเรียน หรือชื่อผู้ปกครอง..." value="{{ request('search') }}">
                    @if(request('search'))
                        <a href="{{ route('students.index') }}" class="text-muted"><i class="fas fa-times-circle"></i></a>
                    @endif
                </div>
                <button type="submit" class="btn btn-dark px-4 rounded-3 shadow-sm">ค้นหา</button>
            </form>
        </div>
    </div>

    <div class="table-container shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light text-muted small uppercase fw-bold">
                    <tr>
                        <th class="ps-4 py-3">ข้อมูลนักศึกษา</th>
                        <th class="text-center">รหัสนักศึกษา</th>
                        <th class="text-center">ชั้นเรียน</th>
                        <th>ผู้ปกครอง / เบอร์ติดต่อ</th> <th class="pe-4 text-end">เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr class="student-row">
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $student->image ? asset('images/' . $student->image) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=4f46e5&color=fff' }}" 
                                     class="rounded-3 me-3 border" style="width: 45px; height: 45px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $student->name }}</div>
                                    <div class="small text-muted">{{ $student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1 fw-normal">{{ $student->student_id }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill" style="background: #eef2ff; color: #4f46e5; padding: 6px 12px;">{{ $student->classroom }}</span>
                        </td>
                        <td>
                            <div class="fw-bold small text-dark">{{ $student->parent_name }}</div>
                            <div class="small text-muted"><i class="fas fa-phone-alt text-success me-1"></i> {{ $student->parent_phone }}</div>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('students.show', $student) }}" class="tool-btn text-primary" title="ดูรายละเอียด">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student) }}" class="tool-btn text-warning" title="แก้ไข">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $student->id }}', '{{ $student->name }}')" class="tool-btn text-danger" title="ลบข้อมูล">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="del-{{ $student->id }}" action="{{ route('students.destroy', $student) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-search fa-3x text-light mb-3"></i>
                            <div class="text-muted">ไม่พบข้อมูลที่คุณค้นหาในขณะนี้</div>
                            <a href="{{ route('students.index') }}" class="btn btn-sm btn-link">ล้างคำค้นหา</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($students->hasPages())
        <div class="p-3 border-top d-flex justify-content-center bg-light-subtle">
            {{ $students->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 600, once: true });

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: "คุณกำลังจะลบข้อมูลของ " + name + " ข้อมูลนี้จะไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#f43f5e',
            confirmButtonText: 'ยืนยัน, ลบเลย!',
            cancelButtonText: 'ยกเลิก',
            borderRadius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('del-' + id).submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
</script>
@endsection