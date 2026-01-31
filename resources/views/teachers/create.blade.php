@extends('layouts.app')

@section('title', 'เพิ่มข้อมูลอาจารย์ใหม่')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f0f2f5; }
    .form-card { border: none; border-radius: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); background: white; }
    .form-label { font-weight: 600; color: #4b5563; font-size: 0.9rem; margin-bottom: 8px; }
    .form-control, .form-select { 
        border-radius: 12px; padding: 12px 15px; border: 1px solid #e5e7eb; background-color: #f9fafb; transition: all 0.2s;
    }
    .form-control:focus { background-color: white; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
    
    .image-preview-wrapper {
        width: 150px; height: 150px; border-radius: 30px; border: 3px dashed #cbd5e1;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
        position: relative; background-color: #f8fafc; margin: 0 auto 20px;
    }
    #imagePreview { width: 100%; height: 100%; object-fit: cover; display: none; }
    .upload-placeholder { text-align: center; color: #94a3b8; }
    
    .section-header { 
        border-left: 5px solid #10b981; padding-left: 15px; margin-bottom: 25px; color: #111827; font-weight: 700;
    }
    .btn-submit { 
        background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; 
        border: none; border-radius: 15px; padding: 12px 30px; font-weight: 600; transition: all 0.3s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); color: white; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('teachers.index') }}" class="btn btn-white btn-sm rounded-circle shadow-sm me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h3 class="fw-bold mb-0">ลงทะเบียนอาจารย์ใหม่</h3>
            </div>

            <div class="card form-card p-4 p-md-5">
                <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4 text-center border-end-md">
                            <div class="section-header">รูปถ่ายอาจารย์</div>
                            <div class="image-preview-wrapper shadow-sm">
                                <img id="imagePreview" src="#" alt="Preview">
                                <div class="upload-placeholder" id="placeholder">
                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                    <p class="small mb-0">เลือกรูปภาพ</p>
                                </div>
                            </div>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4" onclick="document.getElementById('imageInput').click()">
                                <i class="fas fa-upload me-2"></i>อัปโหลดรูป
                            </button>
                            <p class="text-muted small mt-3">รองรับไฟล์ JPG, PNG (สูงสุด 2MB)</p>
                        </div>

                        <div class="col-md-8 ps-md-5">
                            <div class="section-header">ข้อมูลวิชาชีพ</div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">รหัสประจำตัวอาจารย์</label>
                                    <input type="text" name="teacher_id" class="form-control" value="{{ $nextId }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ชื่อ-นามสกุล</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="ระบุชื่อและนามสกุล" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">กลุ่มสาระการเรียนรู้</label>
                                    <select name="department" class="form-select">
                                        <option value="">เลือกกลุ่มสาระ...</option>
                                        <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
                                        <option value="คณิตศาสตร์">คณิตศาสตร์</option>
                                        <option value="ภาษาไทย">ภาษาไทย</option>
                                        <option value="ภาษาต่างประเทศ">ภาษาต่างประเทศ</option>
                                        <option value="สังคมศึกษา">สังคมศึกษา</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ตำแหน่ง</label>
                                    <input type="text" name="position" class="form-control" placeholder="เช่น อาจารย์ผู้สอน, หัวหน้าหมวด">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">วิชาที่รับผิดชอบ</label>
                                    <input type="text" name="subject" class="form-control" placeholder="เช่น ฟิสิกส์, เคมี">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">วันที่เริ่มปฏิบัติงาน</label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" required>
                                </div>
                            </div>

                            <div class="section-header mt-5">การติดต่อและอื่นๆ</div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">อีเมลวิชาการ</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@school.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" name="phone" class="form-control" placeholder="08x-xxx-xxxx">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ที่อยู่ปัจจุบัน</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="บ้านเลขที่, ถนน, ตำบล..."></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">คติประจำใจ (Motto)</label>
                                <input type="text" name="motto" class="form-control" placeholder="เช่น การเรียนรู้ไม่มีที่สิ้นสุด">
                            </div>

                            <div class="text-end mt-5">
                                <button type="reset" class="btn btn-light rounded-pill px-4 me-2">ล้างข้อมูล</button>
                                <button type="submit" class="btn btn-submit shadow">
                                    <i class="fas fa-save me-2"></i> บันทึกข้อมูลอาจารย์
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ระบบ Preview รูปภาพ
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('placeholder');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            placeholder.style.display = 'none';
        }
    }
</script>
@endsection