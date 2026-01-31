@extends('layouts.app')

@section('title', 'โปรไฟล์อาจารย์: ' . $teacher->name)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f0fdf4; }
    
    /* Profile Header Card */
    .profile-card {
        border: none;
        border-radius: 30px;
        background: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .profile-cover {
        height: 160px;
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    }

    .profile-img-container {
        margin-top: -80px;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 160px;
        height: 160px;
        object-fit: cover;
        border: 6px solid white;
        border-radius: 40px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    /* Info Badges */
    .info-label {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .info-value {
        color: #1e293b;
        font-weight: 600;
        font-size: 1.05rem;
    }

    .detail-card {
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 20px;
        height: 100%;
        transition: all 0.3s;
    }
    .detail-card:hover { border-color: #10b981; background: #fcfdfd; }

    .icon-box {
        width: 40px;
        height: 40px;
        background: #d1fae5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .motto-box {
        background: #f8fafc;
        border-left: 5px solid #10b981;
        padding: 20px;
        border-radius: 0 20px 20px 0;
        font-style: italic;
        color: #475569;
    }
</style>

<div class="container py-5 animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('teachers.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> กลับหน้าหลัก
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning rounded-pill px-4 shadow-sm text-white">
                <i class="fas fa-edit me-2"></i> แก้ไขข้อมูล
            </a>
            <button class="btn btn-outline-danger rounded-pill px-4 shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i> พิมพ์
            </button>
        </div>
    </div>

    <div class="profile-card">
        <div class="profile-cover"></div>
        <div class="text-center profile-img-container">
            @if($teacher->image)
                <img src="{{ asset('images/' . $teacher->image) }}" class="profile-img">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=10b981&color=fff&size=200" class="profile-img">
            @endif
        </div>

        <div class="px-4 pb-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-1">{{ $teacher->name }}</h2>
                <span class="badge bg-success rounded-pill px-3 py-2" style="font-weight: 500;">
                    {{ $teacher->position ?: 'อาจารย์ผู้สอน' }}
                </span>
                <p class="text-muted mt-2">รหัสบุคลากร: <span class="fw-bold text-dark">{{ $teacher->teacher_id }}</span></p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="detail-card">
                        <div class="icon-box"><i class="fas fa-university"></i></div>
                        <div class="info-label">กลุ่มสาระการเรียนรู้</div>
                        <div class="info-value text-success">{{ $teacher->department ?: 'ไม่ระบุ' }}</div>
                        <hr class="my-3 opacity-50">
                        <div class="info-label">วิชาที่สอน</div>
                        <div class="info-value">{{ $teacher->subject ?: '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-card">
                        <div class="icon-box"><i class="fas fa-envelope"></i></div>
                        <div class="info-label">ช่องทางติดต่อ</div>
                        <div class="info-value" style="font-size: 0.95rem;">{{ $teacher->email }}</div>
                        <div class="info-value mt-1">{{ $teacher->phone ?: '-' }}</div>
                        <hr class="my-3 opacity-50">
                        <div class="info-label">วันที่เริ่มปฏิบัติงาน</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($teacher->start_date)->isoFormat('D MMMM YYYY') }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-card">
                        <div class="icon-box"><i class="fas fa-graduation-cap"></i></div>
                        <div class="info-label">วุฒิการศึกษา</div>
                        <div class="info-value">{{ $teacher->education_level ?: 'ไม่ระบุข้อมูล' }}</div>
                        <hr class="my-3 opacity-50">
                        <div class="info-label">ที่อยู่ปัจจุบัน</div>
                        <div class="info-value" style="font-size: 0.85rem; font-weight: 500;">
                            {{ $teacher->address ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <div class="info-label mb-2"><i class="fas fa-quote-left text-success me-2"></i>คติประจำใจ</div>
                    <div class="motto-box shadow-sm">
                        "{{ $teacher->motto ?: 'มุ่งมั่นสร้างสรรค์ พัฒนาผู้เรียนสู่อนาคต' }}"
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection