@extends('layouts.app')

@section('title', 'เพิ่มข้อมูลนักเรียนใหม่')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('students.index') }}" class="btn btn-link text-decoration-none text-muted p-0 me-3">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a>
                <h2 class="fw-bold text-dark mb-0">เพิ่มข้อมูลนักเรียนใหม่</h2>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-5">
                            <div class="position-relative d-inline-block">
                                <div class="bg-light rounded-circle shadow-sm border d-flex align-items-center justify-content-center" 
                                     style="width: 150px; height: 150px; overflow: hidden;" id="imagePreview">
                                    <i class="fas fa-user-tie fa-4x text-muted"></i>
                                </div>
                                <label for="image" class="position-absolute bottom-0 end-0 btn btn-primary btn-sm rounded-circle shadow" 
                                       style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewFile()">
                                </label>
                            </div>
                            <p class="text-muted small mt-2">คลิกไอคอนกล้องเพื่อเลือกรูปโปรไฟล์</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label fw-bold">ชื่อ-นามสกุล</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" placeholder="ตัวอย่าง: สมชาย ใจดี" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label fw-bold">อีเมลติดต่อ</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" placeholder="student@gmail.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-5">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('students.index') }}" class="btn btn-light btn-lg rounded-pill px-4 me-md-2">ยกเลิก</a>
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                                        <i class="fas fa-save me-2"></i> บันทึกข้อมูลนักเรียน
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ฟังก์ชันสำหรับดูตัวอย่างรูปภาพก่อนอัปโหลด
    function previewFile() {
        const preview = document.querySelector('#imagePreview');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.innerHTML = `<img src="${reader.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<i class="fas fa-user-tie fa-4x text-muted"></i>';
        }
    }
</script>

<style>
    .form-control, .input-group-text {
        padding: 0.75rem 1rem;
        border-color: #e2e8f0;
    }
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.1);
    }
    .btn-lg {
        font-size: 1rem;
        font-weight: 600;
    }
</style>
@endsection