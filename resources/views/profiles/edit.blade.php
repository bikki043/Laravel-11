@extends('profiles.layout')
@include('layouts.navbar')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { font-family: 'Kanit', sans-serif; background-color: #f1f5f9; }

    /* Layout เดียวกับหน้า Create */
    .admin-form-container {
        max-width: 1000px; margin: 3rem auto;
        background: #ffffff; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden; display: flex;
    }

    .admin-sidebar {
        width: 300px; background: #f8fafc;
        border-right: 1px solid #e2e8f0; padding: 2.5rem;
    }

    .admin-main-content { flex: 1; padding: 2.5rem; }

    .section-title {
        font-size: 1.1rem; font-weight: 700; color: #1e293b;
        margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;
    }

    /* สไตล์ช่องกรอก */
    .admin-label {
        font-size: 0.85rem; font-weight: 600; color: #64748b;
        margin-bottom: 0.5rem; display: block;
    }
    .admin-input {
        width: 100%; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 0.7rem 1rem; font-size: 0.95rem; transition: 0.2s;
    }
    .admin-input:focus {
        border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); outline: none;
    }

    /* จัดการรูปภาพเดิมและรูปใหม่ */
    .edit-photo-wrapper {
        display: flex; align-items: center; gap: 20px; margin-bottom: 2rem;
    }
    .current-photo {
        width: 100px; height: 100px; border-radius: 15px;
        object-fit: cover; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .new-photo-picker {
        width: 100px; height: 100px; border-radius: 15px;
        background: #f1f5f9; border: 2px dashed #cbd5e1;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; overflow: hidden;
    }
    .new-photo-picker img { width: 100%; height: 100%; object-fit: cover; }

    /* Footer Action Bar */
    .form-actions {
        background: #f8fafc; padding: 1.5rem 2.5rem;
        border-top: 1px solid #e2e8f0; display: flex;
        justify-content: flex-end; gap: 12px;
    }

    .btn-update {
        background: #10b981; color: white; border: none;
        padding: 0.7rem 2rem; border-radius: 8px; font-weight: 600; transition: 0.2s;
    }
    .btn-update:hover { background: #059669; transform: translateY(-1px); }

    .btn-cancel {
        background: white; border: 1px solid #e2e8f0; color: #64748b;
        padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none;
    }
</style>

<div class="container">
    <div class="admin-form-container">
        
        <div class="admin-sidebar d-none d-lg-block">
            <h5 class="fw-bold mb-4 text-dark">แก้ไขข้อมูล</h5>
            <div class="text-center mb-4">
                @if($profile->image)
                    <img src="{{ asset('images/' . $profile->image) }}" class="rounded-circle mb-3 border shadow-sm" width="80" height="80" style="object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person text-white fs-1"></i>
                    </div>
                @endif
                <h6 class="mb-0 fw-bold text-truncate">{{ $profile->name }}</h6>
                <small class="text-muted">Admin ID: #{{ $profile->id }}</small>
            </div>
            <hr>
            <nav class="nav flex-column gap-2 mt-4">
                <span class="small text-uppercase fw-bold text-muted mb-2" style="letter-spacing: 1px;">เมนูจัดการ</span>
                <a class="nav-link p-0 active text-primary fw-bold" href="#"><i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลหลัก</a>
                <a class="nav-link p-0 text-muted" href="#"><i class="bi bi-key me-2"></i> เปลี่ยนรหัสผ่าน</a>
            </nav>
        </div>

        <div class="admin-main-content">
            <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="section-title">
                    <i class="bi bi-gear-wide-connected text-primary"></i> แก้ไขรายละเอียดโปรไฟล์
                </div>

                <label class="admin-label">รูปถ่ายโปรไฟล์</label>
                <div class="edit-photo-wrapper">
                    <div class="text-center">
                        @if($profile->image)
                            <img src="{{ asset('images/' . $profile->image) }}" class="current-photo" id="oldPhoto">
                        @endif
                        <div class="small text-muted mt-1">รูปปัจจุบัน</div>
                    </div>
                    
                    <i class="bi bi-arrow-right text-muted fs-4"></i>

                    <div class="text-center">
                        <label for="image" class="new-photo-picker shadow-sm" id="imgView">
                            <i class="bi bi-cloud-upload text-muted fs-4"></i>
                        </label>
                        <div class="small text-primary mt-1 fw-bold">อัปโหลดใหม่</div>
                    </div>
                    <input type="file" name="image" id="image" class="d-none" onchange="previewImage(event)">
                </div>
                @error('image') <small class="text-danger d-block mb-3">{{$message}}</small> @enderror

                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="admin-label">ชื่อสมาชิก (Name)</label>
                        <input type="text" name="name" class="admin-input @error('name') is-invalid @enderror" 
                               value="{{ old('name', $profile->name) }}" required>
                        @error('name') <small class="text-danger">{{$message}}</small> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="admin-label">อีเมลติดต่อ (Email)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope-at text-muted"></i></span>
                            <input type="email" name="email" class="admin-input border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $profile->email) }}" required style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        </div>
                        @error('email') <small class="text-danger d-block mt-1">{{$message}}</small> @enderror
                    </div>
                </div>

                <div class="form-actions mt-5 mx-n4 mb-n4">
                    <a href="{{ route('profiles.index') }}" class="btn-cancel">ยกเลิกการแก้ไข</a>
                    <button type="submit" class="btn-update shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> อัปเดตข้อมูล
                    </button>
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
            output.innerHTML = `<img src="${reader.result}" class="animate__animated animate__fadeIn">`;
            output.style.border = '2px solid #10b981';
        }
        if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection