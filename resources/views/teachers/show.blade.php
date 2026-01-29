@extends('layouts.app')

@section('title', 'โปรไฟล์อาจารย์')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('teachers.index') }}" class="text-decoration-none text-muted">
                    <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
                </a>
                <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning btn-sm rounded-pill px-4 text-white shadow-sm">
                    <i class="fas fa-edit me-1"></i> แก้ไขโปรไฟล์
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5 bg-light text-center p-5 border-end">
                            <div class="mb-4">
                                @if($teacher->image)
                                    <img src="{{ asset('images/' . $teacher->image) }}" 
                                         class="rounded-circle shadow-sm border border-4 border-white" 
                                         style="width: 180px; height: 180px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=6366f1&color=fff&size=180" 
                                         class="rounded-circle shadow-sm border border-4 border-white">
                                @endif
                            </div>
                            <h4 class="fw-bold text-dark mb-1">{{ $teacher->name }}</h4>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">อาจารย์ (Teacher)</span>
                            <div class="mt-3 text-muted small">
                                <strong>ID:</strong> #{{ str_pad($teacher->id, 5, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                        <div class="col-md-7 p-5">
                            <h5 class="fw-bold mb-4 text-dark">ข้อมูลส่วนตัว</h5>
                            
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-box bg-blue-light rounded-3 p-3 me-3 text-primary">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">อีเมลติดต่อ</small>
                                    <span class="h6 mb-0">{{ $teacher->email }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-box bg-green-light rounded-3 p-3 me-3 text-success">
                                    <i class="fas fa-calendar-alt fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">ลงทะเบียนเมื่อ</small>
                                    <span class="h6 mb-0">{{ $teacher->created_at->isoFormat('D MMMM YYYY') }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-0">
                                <div class="icon-box bg-orange-light rounded-3 p-3 me-3 text-warning">
                                    <i class="fas fa-history fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">ปรับปรุงข้อมูลล่าสุด</small>
                                    <span class="h6 mb-0">{{ $teacher->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-center text-muted mt-4 small">
                <i class="fas fa-lock me-1"></i> ข้อมูลนี้ถูกจัดการผ่านระบบฐานข้อมูลอาจารย์
            </p>
        </div>
    </div>
</div>

<style>
    .bg-blue-light { background-color: #eef2ff; }
    .bg-green-light { background-color: #f0fdf4; }
    .bg-orange-light { background-color: #fffaf0; }
    .icon-box { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; }
</style>


@endsection