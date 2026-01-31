@extends('layouts.app')

@section('title', 'แก้ไขข้อมูล: ' . $student->name)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f1f5f9; }
    .form-card { border: none; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .form-header { background: linear-gradient(45deg, #f59e0b, #fbbf24); color: white; padding: 30px; }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; }
    .section-title i { width: 35px; height: 35px; background: #fff7ed; color: #f59e0b; display: flex; align-items: center; justify-content: center; border-radius: 10px; margin-right: 12px; }
    .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; transition: 0.3s; }
    .form-control:focus { border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1); }
    
    /* ปรับขนาดรูป Preview ให้ใหญ่ขึ้นตามคำขอ */
    .preview-container { 
        width: 150px; 
        height: 150px; 
        border-radius: 20px; 
        border: 3px solid #f59e0b; 
        overflow: hidden; 
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    #imagePreview img { width: 100%; height: 100%; object-fit: cover; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card form-card">
                    <div class="form-header d-flex justify-content-between align-items-center shadow-sm">
                        <div>
                            <h3 class="fw-bold mb-1"><i class="fas fa-edit me-2"></i> แก้ไขข้อมูลนักเรียน</h3>
                            <p class="mb-0 opacity-75">รหัสประจำตัวนักเรียน: <strong>{{ $student->student_id }}</strong></p>
                        </div>
                        <i class="fas fa-user-graduate fa-4x opacity-25"></i>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4 mb-5 align-items-center">
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="preview-container mb-3 shadow-sm" id="imagePreview">
                                        @if($student->image)
                                            <img src="{{ asset('images/' . $student->image) }}">
                                        @else
                                            <i class="fas fa-user fa-4x text-light"></i>
                                        @endif
                                    </div>
                                    <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                    <button type="button" class="btn btn-warning btn-sm rounded-pill px-4 text-white shadow-sm" onclick="document.getElementById('imageInput').click()">
                                        <i class="fas fa-camera me-1"></i> เปลี่ยนรูปภาพ
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">ชื่อ-นามสกุล</label>
                                        <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">ชื่อเล่น</label>
                                        <input type="text" name="nickname" class="form-control" value="{{ $student->nickname }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">ระดับชั้น / ห้อง</label>
                                        <input type="text" name="classroom" class="form-control" value="{{ $student->classroom }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-danger">รหัสนักเรียน (แก้ไขไม่ได้)</label>
                                        <input type="text" class="form-control bg-light" value="{{ $student->student_id }}" readonly disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-25">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="section-title"><i class="fas fa-hand-holding-med"></i> ข้อมูลสุขภาพ</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">หมู่เลือด</label>
                                        <select name="blood_group" class="form-select">
                                            @foreach(['A', 'B', 'O', 'AB'] as $bg)
                                                <option value="{{ $bg }}" {{ $student->blood_group == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">โรคประจำตัว</label>
                                        <input type="text" name="congenital_disease" class="form-control" value="{{ $student->congenital_disease }}" placeholder="ถ้าไม่มีให้เว้นว่าง">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">ประวัติการแพ้ (ยา/อาหาร)</label>
                                        <input type="text" name="allergy" class="form-control" value="{{ $student->allergy }}" placeholder="ระบุสิ่งที่แพ้">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="section-title"><i class="fas fa-id-card"></i> ข้อมูลการติดต่อ</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">ชื่อผู้ปกครอง</label>
                                        <input type="text" name="parent_name" class="form-control" value="{{ $student->parent_name }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">เบอร์โทรศัพท์ผู้ปกครอง</label>
                                        <input type="text" name="parent_phone" class="form-control" value="{{ $student->parent_phone }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">ที่อยู่ปัจจุบัน</label>
                                        <textarea name="address" class="form-control" rows="3" required>{{ $student->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="{{ route('students.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm">
                                <i class="fas fa-times me-1"></i> ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold text-white shadow">
                                <i class="fas fa-save me-1"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // สคริปต์ดูตัวอย่างรูปภาพก่อนบันทึก
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files
        if (file) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `<img src="${URL.createObjectURL(file)}" class="animate__animated animate__fadeIn">`;
        }
    }
</script>
@endsection