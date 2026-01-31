@extends('layouts.app')

@section('title', 'ลงทะเบียนนักเรียนใหม่')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f1f5f9; }
    .form-card { border: none; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .form-header { background: #4f46e5; color: white; padding: 30px; }
    .input-group-text { background: #f8fafc; border-right: none; color: #64748b; border-radius: 12px 0 0 12px; }
    .form-control, .form-select { border-left: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; border-color: #e2e8f0; }
    .form-control:focus, .form-select:focus { box-shadow: none; border-color: #4f46e5; }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; }
    .section-title i { width: 30px; height: 30px; background: #eef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-right: 12px; font-size: 0.9rem; }
    .preview-container { width: 120px; height: 120px; border-radius: 20px; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
    #imagePreview img { width: 100%; height: 100%; object-fit: cover; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            @if ($errors->any())
                <div class="alert alert-danger mb-4 shadow-sm" style="border-radius: 15px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card form-card">
                    <div class="form-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-1">ลงทะเบียนนักเรียนใหม่</h3>
                            <p class="mb-0 opacity-75">กรุณากรอกข้อมูลให้ครบถ้วนเพื่อสร้างประวัตินักเรียน</p>
                        </div>
                        <i class="fas fa-user-plus fa-3x opacity-25"></i>
                    </div>

                    <div class="card-body p-5">
                        <div class="section-title"><i class="fas fa-info"></i> ข้อมูลพื้นฐาน</div>
                        <div class="row g-4 mb-5">
                            <div class="col-md-4 text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="preview-container mb-3" id="imagePreview">
                                        <i class="fas fa-camera fa-2x text-muted"></i>
                                    </div>
                                    <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="document.getElementById('imageInput').click()">เลือกรูปถ่าย</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">รหัสนักเรียน</label>
                                        <input type="text" name="student_id" class="form-control bg-light" value="{{ $nextId }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">ระดับชั้น / ห้อง</label>
                                        <input type="text" name="classroom" class="form-control" placeholder="เช่น ม.6/1" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold">ชื่อ-นามสกุล</label>
                                        <input type="text" name="name" class="form-control" placeholder="ระบุชื่อจริง-นามสกุล" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">ชื่อเล่น</label>
                                        <input type="text" name="nickname" class="form-control" placeholder="เช่น น้องก้อง">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-5 mb-5">
                            <div class="col-md-6">
                                <div class="section-title"><i class="fas fa-user"></i> รายละเอียดส่วนตัว</div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">อีเมลติดต่อ</label>
                                    <input type="email" name="email" class="form-control" placeholder="student@example.com" required>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold">เพศ</label>
                                        <select name="gender" class="form-select" required>
                                            <option value="male">ชาย</option>
                                            <option value="female">หญิง</option>
                                            <option value="other">อื่นๆ</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold">วัน/เดือน/ปีเกิด</label>
                                        <input type="date" name="birth_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">ที่อยู่ปัจจุบัน</label>
                                    <textarea name="address" class="form-control" rows="2" placeholder="ระบุบ้านเลขที่ ซอย ถนน..." required></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="section-title"><i class="fas fa-heartbeat"></i> ข้อมูลสุขภาพ</div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">หมู่เลือด</label>
                                    <select name="blood_group" class="form-select">
                                        <option value="">ระบุหมู่เลือด</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="O">O</option>
                                        <option value="AB">AB</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">โรคประจำตัว (ถ้ามี)</label>
                                    <input type="text" name="congenital_disease" class="form-control" placeholder="ระบุโรคประจำตัว">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">ประวัติการแพ้ (ยา/อาหาร)</label>
                                    <textarea name="allergy" class="form-control" rows="1" placeholder="เช่น แพ้อาหารทะเล, ไม่มี"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="section-title"><i class="fas fa-users"></i> ข้อมูลติดต่อผู้ปกครอง</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">ชื่อผู้ปกครอง</label>
                                <input type="text" name="parent_name" class="form-control" placeholder="ชื่อ-นามสกุล ผู้ปกครอง" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">เบอร์โทรศัพท์ฉุกเฉิน</label>
                                <input type="text" name="parent_phone" class="form-control" placeholder="08x-xxx-xxxx" required>
                            </div>
                        </div>

                        <hr class="my-5 opacity-50">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('students.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">ยกเลิก</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold" style="background: #4f46e5; border: none;">บันทึกข้อมูลนักเรียน</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // ระบบพรีวิวรูปภาพก่อนอัปโหลด
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files
        if (file) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `<img src="${URL.createObjectURL(file)}">`;
        }
    }
</script>
@endsection