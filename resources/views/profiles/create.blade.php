@extends('profiles.layout')
@include('layouts.navbar')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { font-family: 'Kanit', sans-serif; background-color: #f1f5f9; }

    /* Layout การ์ดแบบ Admin Panel */
    .admin-form-container {
        max-width: 1000px; margin: 3rem auto;
        background: #ffffff; border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden; display: flex;
    }

    /* ฝั่งซ้าย: Navigation/Info */
    .admin-sidebar {
        width: 300px; background: #f8fafc;
        border-right: 1px solid #e2e8f0; padding: 2.5rem;
    }

    /* ฝั่งขวา: Form พื้นที่กรอก */
    .admin-main-content { flex: 1; padding: 2.5rem; }

    .section-title {
        font-size: 1.1rem; font-weight: 700; color: #1e293b;
        margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;
    }

    /* Input สไตล์เนี๊ยบ */
    .admin-label {
        font-size: 0.85rem; font-weight: 600; color: #64748b;
        margin-bottom: 0.5rem; display: block;
    }
    .admin-input {
        width: 100%; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 0.6rem 1rem; font-size: 0.95rem; transition: 0.2s;
    }
    .admin-input:focus {
        border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); outline: none;
    }

    /* โซนรูปภาพแบบ Admin Profile */
    .admin-photo-picker {
        width: 100px; height: 100px; border-radius: 12px;
        background: #f1f5f9; border: 2px dashed #cbd5e1;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; overflow: hidden; position: relative;
    }
    .admin-photo-picker img { width: 100%; height: 100%; object-fit: cover; }

    /* Footer Action Bar */
    .form-actions {
        background: #f8fafc; padding: 1.5rem 2.5rem;
        border-top: 1px solid #e2e8f0; display: flex;
        justify-content: flex-end; gap: 12px;
    }

    .btn-save {
        background: #4f46e5; color: white; border: none;
        padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600; transition: 0.2s;
    }
    .btn-save:hover { background: #4338ca; }

    .btn-cancel {
        background: white; border: 1px solid #e2e8f0; color: #64748b;
        padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 600;
    }
</style>

<div class="container">
    <div class="admin-form-container">
        <div class="admin-sidebar d-none d-lg-block">
            <h5 class="fw-bold mb-4">การตั้งค่าบัญชี</h5>
            <nav class="nav flex-column gap-3">
                <a class="nav-link p-0 active text-primary fw-bold" href="#"><i class="bi bi-person-plus me-2"></i> ข้อมูลพื้นฐาน</a>
                <a class="nav-link p-0 text-muted" href="#"><i class="bi bi-shield-lock me-2"></i> สิทธิ์การเข้าถึง</a>
                <a class="nav-link p-0 text-muted" href="#"><i class="bi bi-bell me-2"></i> การแจ้งเตือน</a>
            </nav>
            <hr class="my-4">
            <p class="small text-muted">ระบุข้อมูลที่ถูกต้องเพื่อใช้ในการยืนยันตัวตนในระบบแอดมิน</p>
        </div>

        <div class="admin-main-content">
            <form action="{{route('profiles.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="section-title">
                    <i class="bi bi-person-circle text-primary"></i> เพิ่มรายชื่อผู้ดูแลระบบ (Add Admin)
                </div>

                <div class="mb-4 d-flex align-items-center gap-4">
                    <label for="image" class="admin-photo-picker shadow-sm" id="imgView">
                        <i class="bi bi-camera text-muted fs-4"></i>
                    </label>
                    <div>
                        <span class="admin-label m-0">รูปถ่ายโปรไฟล์</span>
                        <p class="text-muted small m-0">PNG, JPG ขนาดไม่เกิน 2MB</p>
                        <input type="file" name="image" id="image" class="d-none" onchange="previewImage(event)">
                        @error('image') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="admin-label">ชื่อสมาชิก / ชื่อแอดมิน (Display Name)</label>
                        <input type="text" name="name" class="admin-input @error('name') is-invalid @enderror" 
                               placeholder="กรอกชื่อ-นามสกุล..." value="{{old('name')}}">
                        @error('name') <small class="text-danger">{{$message}}</small> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="admin-label">ที่อยู่อีเมลหลัก (Primary Email)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="admin-input border-start-0 @error('email') is-invalid @enderror" 
                                   placeholder="admin@yourcompany.com" value="{{old('email')}}" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        </div>
                        @error('email') <small class="text-danger d-block mt-1">{{$message}}</small> @enderror
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" checked>
                                <label class="form-check-label admin-label ms-2 mb-0" for="flexSwitchCheckDefault">เปิดใช้งานบัญชีทันที (Activate Account)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions mt-5 mx-n4 mb-n4">
                    <a href="{{ route('profiles.index') }}" class="btn btn-cancel">ยกเลิก</a>
                    <button type="submit" class="btn btn-save">บันทึกข้อมูลและสร้างบัญชี</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imgView');
            output.innerHTML = `<img src="${reader.result}">`;
            output.style.border = '1px solid #4f46e5';
        }
        if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection