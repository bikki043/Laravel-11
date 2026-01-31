@extends('layouts.app')

@section('title', 'แก้ไขข้อมูล: ' . $teacher->name)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f8fafc; } /* เปลี่ยนให้เข้าโทน Index */
    .card { border: none; border-radius: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); background: white; }
    
    .form-label { font-weight: 600; color: #475569; font-size: 0.9rem; }
    .form-control { 
        border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; background-color: #f8fafc; transition: all 0.3s;
    }
    .form-control:focus { 
        background-color: white; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); 
    }
    .form-control.is-invalid { border-color: #ef4444; }

    .btn-update { 
        background: linear-gradient(135deg, #059669 0%, #10b981 100%); 
        color: white; border: none; border-radius: 15px; padding: 14px; font-weight: 600; transition: 0.3s;
    }
    .btn-update:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); color: white; }
    
    .section-title { color: #065f46; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; font-size: 1.1rem; }
    .section-title i { margin-right: 12px; background: #d1fae5; color: #059669; padding: 10px; border-radius: 12px; }
    
    .preview-img-container { position: relative; display: inline-block; }
    .preview-img { width: 180px; height: 180px; object-fit: cover; border-radius: 25px; border: 5px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    
    .sticky-info { position: sticky; top: 20px; }
</style>

<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">แก้ไขข้อมูลคณาจารย์</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}" class="text-decoration-none text-muted">คณาจารย์</a></li>
                    <li class="breadcrumb-item active text-success">แก้ไขข้อมูล</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('teachers.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> ย้อนกลับ
        </a>
    </div>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card p-4 text-center sticky-info">
                    <div class="section-title justify-content-center"><i class="fas fa-image"></i> รูปถ่าย</div>
                    
                    <div class="preview-img-container mb-4">
                        @if($teacher->image)
                            <img id="preview" src="{{ asset('images/' . $teacher->image) }}" class="preview-img">
                        @else
                            <img id="preview" src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=10b981&color=fff&size=200" class="preview-img">
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label d-block">เปลี่ยนรูปโปรไฟล์</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(event)">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="text-start bg-light p-3 rounded-4">
                        <label class="form-label mb-1">รหัสประจำตัวอาจารย์</label>
                        <div class="h5 fw-bold text-success mb-0">{{ $teacher->teacher_id }}</div>
                        <small class="text-muted">รหัสนี้ไม่สามารถแก้ไขได้</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card p-4 p-md-5">
                    <div class="section-title"><i class="fas fa-user"></i> ข้อมูลส่วนตัว</div>
                    <div class="row g-3 mb-5">
                        <div class="col-md-12">
                            <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $teacher->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ตำแหน่งทางการเงิน/วิชาการ</label>
                            <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $teacher->position) }}" placeholder="เช่น อาจารย์, ผศ.ดร.">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">กลุ่มสาระ / ภาควิชา</label>
                            <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department', $teacher->department) }}" placeholder="เช่น คณิตศาสตร์">
                        </div>
                    </div>

                    <div class="section-title"><i class="fas fa-address-book"></i> ช่องทางติดต่อ</div>
                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $teacher->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $teacher->phone) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">ที่อยู่ปัจจุบัน</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="ระบุที่อยู่ที่สามารถติดต่อได้">{{ old('address', $teacher->address) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-update flex-grow-1 shadow-lg">
                            <i class="fas fa-save me-2"></i> บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="{{ route('teachers.index') }}" class="btn btn-light rounded-pill px-4 border">ยกเลิก</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.add('animate__animated', 'animate__fadeIn');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection