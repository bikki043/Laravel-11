@extends('layouts.app')

@section('title', 'โปรไฟล์นักเรียน - ' . $student->name)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f8fafc; color: #1e293b; }
    
    .profile-card { 
        border: none; 
        border-radius: 35px; 
        overflow: hidden; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        background: white;
    }

    .profile-header { 
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); 
        padding: 40px; /* ปรับลด padding ลงเล็กน้อยให้สมดุลกับรูป 150px */
        color: white; 
        position: relative;
        overflow: hidden;
    }

    .profile-header::after {
        content: "";
        position: absolute;
        top: -10%; right: -5%;
        width: 300px; height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* ปรับขนาดรูปให้เท่ากับหน้า Edit (150px) */
    .student-img { 
        width: 150px; 
        height: 150px; 
        object-fit: cover; 
        border-radius: 30px; 
        border: 5px solid rgba(255,255,255,0.25);
        transition: transform 0.3s ease;
    }
    .student-img:hover { transform: scale(1.05); }

    .info-label { color: #94a3b8; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
    .info-value { color: #334155; font-weight: 600; font-size: 1.1rem; margin-bottom: 25px; }
    
    .stat-box {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 12px 20px;
        border-radius: 15px;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .section-title {
        border-left: 5px solid #4f46e5;
        padding-left: 15px;
        margin-bottom: 30px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .health-section .section-title { border-left-color: #ef4444; }

    .btn-action { transition: all 0.2s ease; border-radius: 15px; padding: 10px 25px; }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
</style>

<div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10 d-flex justify-content-between align-items-center">
            <a href="{{ route('students.index') }}" class="btn btn-white btn-action shadow-sm text-secondary">
                <i class="fas fa-chevron-left me-2"></i> รายชื่อทั้งหมด
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-action text-white shadow-sm">
                    <i class="fas fa-user-edit me-2"></i> แก้ไขข้อมูล
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card profile-card">
                <div class="profile-header">
                    <div class="row align-items-center position-relative" style="z-index: 1;">
                        <div class="col-md-auto text-center mb-4 mb-md-0">
                            @if($student->image)
                                <img src="{{ asset('images/' . $student->image) }}" class="student-img shadow-lg">
                            @else
                                <div class="student-img shadow-lg bg-white d-flex align-items-center justify-content-center text-primary">
                                    <i class="fas fa-user-graduate fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md ps-md-5">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="stat-box small fw-bold"><i class="fas fa-fingerprint me-2"></i>{{ $student->student_id }}</span>
                                <span class="stat-box small fw-bold"><i class="fas fa-graduation-cap me-2"></i>{{ $student->classroom }}</span>
                            </div>
                            <h1 class="display-6 fw-bold mb-1">{{ $student->name }}</h1>
                            <p class="fs-5 opacity-75 mb-0">ชื่อเล่น: {{ $student->nickname ?: 'ไม่ระบุ' }} • เพศ{{ $student->gender == 'male' ? 'ชาย' : 'หญิง' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-5 mb-md-0 border-end">
                            <h4 class="section-title">ข้อมูลส่วนตัว</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="info-label">วันเกิด / อายุ</div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }} 
                                        <span class="badge bg-light text-primary ms-1">{{ \Carbon\Carbon::parse($student->birth_date)->age }} ปี</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-label">อีเมลติดต่อ</div>
                                    <div class="info-value text-break">{{ $student->email }}</div>
                                </div>
                            </div>
                            <div class="info-label">ที่อยู่ตามทะเบียนบ้าน</div>
                            <div class="info-value" style="line-height: 1.6;">{{ $student->address }}</div>
                            <div class="p-4 rounded-4 bg-light border-0">
                                <div class="info-label"><i class="fas fa-user-shield me-2"></i>ผู้ปกครองที่ดูแล</div>
                                <div class="info-value mb-1">{{ $student->parent_name }}</div>
                                <div class="h5 mb-0 text-primary fw-bold">
                                    <i class="fas fa-phone-square-alt me-2"></i>{{ $student->parent_phone }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-5 health-section">
                            <h4 class="section-title text-danger">สุขภาพและข้อมูลสำคัญ</h4>
                            <div class="row mb-4">
                                <div class="col-4 text-center border-end">
                                    <div class="info-label">หมู่เลือด</div>
                                    <div class="display-6 fw-bold text-danger">{{ $student->blood_group ?: '?' }}</div>
                                </div>
                                <div class="col-8 ps-4">
                                    <div class="info-label">โรคประจำตัว</div>
                                    <div class="info-value {{ $student->congenital_disease ? 'text-danger' : '' }}">
                                        {{ $student->congenital_disease ?: 'ไม่มีประวัติ' }}
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-warning border-0 rounded-4 p-4 mb-4">
                                <div class="info-label text-warning-emphasis">ข้อมูลการแพ้ (ยา/อาหาร)</div>
                                <div class="info-value mb-0">
                                    @if($student->allergy)
                                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $student->allergy }}
                                    @else
                                        ไม่มีข้อมูลการแพ้
                                    @endif
                                </div>
                            </div>
                            <div class="text-center mt-auto p-4 border rounded-4 border-dashed">
                                <p class="small text-muted mb-0">ปรับปรุงข้อมูลล่าสุดเมื่อ: {{ $student->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection