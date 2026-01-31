@extends('layouts.app')

@section('title', 'แผงควบคุมหลัก - Real-time Dashboard')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* --- พื้นหลังหลักและภาพจางๆ --- */
    body { 
        font-family: 'Prompt', sans-serif; 
        background-color: #f4f7fa; 
        color: #334155; 
        position: relative;
        min-height: 100vh;
        overflow-x: hidden;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        /* ใส่ URL รูปภาพพื้นหลังที่นี่ */
        background-image: linear-gradient(135deg, rgba(244, 247, 250, 0.9), rgba(226, 232, 240, 0.8)), 
                          url('https://www.transparenttextures.com/patterns/cubes.png'); 
        background-size: cover;
        background-attachment: fixed;
        z-index: -1;
        opacity: 0.6; /* ปรับความเข้ม-จางของภาพพื้นหลังรวม */
    }
    
    /* ระบบนาฬิกาดิจิทัล */
    #realtime-clock {
        font-family: 'monospace', 'Prompt';
        font-size: 1.2rem;
        background: rgba(30, 41, 59, 0.9);
        color: #10b981;
        padding: 4px 12px;
        border-radius: 10px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
        display: inline-block;
    }

    /* Glassmorphism Effect สำหรับ Card และ Table */
    .card-stat, .main-table, .btn-action, .recent-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05) !important;
    }

    .card-stat {
        padding: 1.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .card-stat:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.9) !important;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1) !important;
    }

    /* แอนิเมชันเมื่อข้อมูลอัปเดต */
    .update-flash {
        animation: flashHighlight 1.5s ease-out;
    }
    @keyframes flashHighlight {
        0% { background-color: rgba(16, 185, 129, 0.2); }
        100% { background-color: transparent; }
    }

    .main-table {
        overflow: hidden;
    }

    .img-frame {
        width: 48px; height: 48px;
        border-radius: 16px;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .btn-action {
        padding: 1.2rem;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #475569;
        transition: 0.3s;
        margin-bottom: 12px;
    }
    .btn-action:hover {
        border-color: #4f46e5 !important;
        color: #4f46e5 !important;
        transform: scale(1.02);
        background: rgba(255, 255, 255, 1) !important;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .dot-live {
        width: 8px; height: 8px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<div class="container-fluid py-4">
    <div class="row align-items-center mb-5 px-3" data-aos="fade-down">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark mb-1 hstack gap-3">
                ระบบจัดการฐานข้อมูล<span class="text-primary">LmsPro</span>
                <span id="realtime-clock" class="animate__animated animate__fadeIn">00:00:00</span>
            </h2>
            <div class="text-muted mb-0 d-flex align-items-center gap-3 flex-wrap mt-2">
                <div class="hstack gap-2">
                    <i class="far fa-calendar-alt text-primary"></i> 
                    <span class="fw-medium text-dark">{{ date('d F Y') }}</span>
                </div>
                <span class="vr"></span>
                <div class="status-badge bg-success-subtle text-success border border-success-subtle shadow-sm">
                    <div class="dot-live"></div> 
                    <small>ระบบเชื่อมต่อเรียลไทม์ปกติ</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <button onclick="location.reload()" class="btn btn-white shadow-sm rounded-4 border-0 p-3 bg-white">
                <i class="fas fa-sync-alt text-primary"></i>
            </button>
        </div>
    </div>

    <div class="row g-4 mb-5" id="stats-container">
        @php
            $cards = [
                ['id' => 'stat-students', 'title' => 'นักเรียนทั้งหมด', 'val' => $totalStudents, 'icon' => 'fa-user-graduate', 'color' => '#4f46e5'],
                ['id' => 'stat-teachers', 'title' => 'บุคลากรอาจารย์', 'val' => $totalTeachers, 'icon' => 'fa-chalkboard-teacher', 'color' => '#10b981'],
                ['id' => 'stat-users', 'title' => 'บัญชีผู้ใช้', 'val' => $totalUsers, 'icon' => 'fa-shield-alt', 'color' => '#f59e0b'],
                ['id' => 'stat-profiles', 'title' => 'แอดมินระบบ', 'val' => $profiles->total(), 'icon' => 'fa-user-shield', 'color' => '#06b6d4']
            ];
        @endphp
        @foreach($cards as $index => $c)
        <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
            <div class="card card-stat" id="{{ $c['id'] }}">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-4 p-3 me-3" style="background: {{ $c['color'] }}15; color: {{ $c['color'] }}">
                        <i class="fas {{ $c['icon'] }} fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">{{ $c['title'] }}</div>
                        <h3 class="fw-bold mb-0 counter-value">{{ number_format($c['val']) }}</h3>
                    </div>
                </div>
                <div class="pt-2 border-top hstack justify-content-between">
                    <span class="badge bg-light text-dark rounded-pill fw-light" style="font-size: 10px;">
                        <i class="fas fa-history me-1 text-success"></i> Sync 
                    </span>
                    <i class="fas fa-check-circle text-success opacity-50" style="font-size: 12px;"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8" data-aos="fade-up">
            <div class="main-table shadow-sm border-0">
                <div class="p-4 bg-white bg-opacity-50 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 hstack gap-2">
                        <i class="fas fa-users-viewfinder text-primary"></i> นักเรียนล่าสุด
                    </h5>
                    <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">ดูรายชื่อทั้งหมด</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="recent-table">
                        <thead>
                            <tr class="text-muted small">
                                <th class="ps-4 py-3">ข้อมูลนักเรียน</th>
                                <th>สถานะ</th>
                                <th>บันทึกเมื่อ</th>
                                <th class="text-center">เครื่องมือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStudents as $student)
                            <tr class="student-row">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $student->image ? asset('images/'.$student->image) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=4f46e5&color=fff&bold=true' }}" class="img-frame me-3">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $student->name }}</div>
                                            <div class="text-muted small">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge bg-success-subtle text-success">
                                        <div class="dot-live"></div> ออนไลน์
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $student->created_at ? $student->created_at->diffForHumans() : 'เมื่อครู่' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-light btn-sm rounded-pill px-3 border shadow-sm">เรียกดู</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 opacity-50">ไม่มีข้อมูลใหม่</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div data-aos="fade-left">
                <h6 class="fw-bold mb-3 hstack gap-2 text-dark">
                    <i class="fas fa-bolt text-warning"></i>จัดการด่วน
                </h6>
                <div class="mb-4">
                    <a href="{{ route('students.create') }}" class="btn-action shadow-sm">
                        <i class="fas fa-plus text-primary fs-5 me-3"></i>
                        <div><div class="fw-bold small">เพิ่มนักเรียน</div><small class="text-muted">Add New Student</small></div>
                    </a>
                    <a href="{{ route('teachers.create') }}" class="btn-action shadow-sm">
                        <i class="fas fa-user-plus text-success fs-5 me-3"></i>
                        <div><div class="fw-bold small">เพิ่มคณาจารย์</div><small class="text-muted">Add New Teacher</small></div>
                    </a>
                </div>

                <div class="recent-card p-4">
                    <h6 class="fw-bold mb-4">คณาจารย์ล่าสุด</h6>
                    @foreach($recentTeachers as $teacher)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $teacher->image ? asset('images/'.$teacher->image) : 'https://ui-avatars.com/api/?name='.urlencode($teacher->name).'&background=f8fafc&color=64748b' }}" class="rounded-circle border border-2 border-white shadow-sm" width="40" height="40">
                        <div class="ms-3">
                            <div class="fw-bold small" style="font-size: 13px;">{{ $teacher->name }}</div>
                            <div class="text-muted" style="font-size: 10px;">{{ $teacher->department ?: 'ทั่วไป' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    function updateClock() {
        const now = new Date();
        const clock = document.getElementById('realtime-clock');
        if(clock) clock.textContent = now.toLocaleTimeString('th-TH', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    function simulateDataSync() {
        const statIds = ['stat-students', 'stat-teachers', 'stat-users', 'stat-profiles'];
        const randomId = statIds[Math.floor(Math.random() * statIds.length)];
        const el = document.getElementById(randomId);
        if(el) {
            el.classList.add('update-flash');
            setTimeout(() => el.classList.remove('update-flash'), 1500);
        }
    }
    setInterval(simulateDataSync, 7000);
</script>
@endsection