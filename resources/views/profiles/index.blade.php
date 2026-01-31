@extends('profiles.layout')
@include('layouts.navbar')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { font-family: 'Kanit', sans-serif; background-color: #f8fafc; color: #1e293b; }
    
    /* Header & Clock */
    .admin-header {
        background: white;
        padding: 2rem;
        border-radius: 24px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        margin-bottom: 2rem;
    }
    #live-clock {
        font-family: monospace;
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 8px;
        font-weight: bold;
        color: #4f46e5;
    }

    /* Stat Cards */
    .stat-card {
        background: white; border-radius: 20px; padding: 1.5rem;
        border: 1px solid rgba(226,232,240,0.5); 
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }

    /* Table System */
    .table-container {
        background: white; border-radius: 24px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    
    .search-control { 
        padding-left: 45px; border-radius: 15px; border: 1px solid #e2e8f0; 
        background: #f8fafc; height: 50px;
    }

    .admin-table thead th { 
        background: #f8fafc; color: #64748b; text-transform: uppercase; 
        font-size: 0.75rem; letter-spacing: 0.05em; padding: 1.2rem;
    }

    .user-avatar {
        width: 45px; height: 45px; border-radius: 12px;
        object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-action-group .btn {
        width: 35px; height: 35px; display: inline-flex;
        align-items: center; justify-content: center; border-radius: 10px;
        margin: 0 2px; transition: 0.2s;
    }

    .dot-active {
        width: 8px; height: 8px; background: #10b981;
        border-radius: 50%; display: inline-block;
        animation: pulse-green 2s infinite;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<div class="container py-4">
    <div class="admin-header d-flex justify-content-between align-items-center flex-wrap" data-aos="fade-down">
        <div>
            <h3 class="fw-bold mb-1">ระบบจัดการ <span class="text-primary">ผู้ดูแลระบบ</span></h3>
            <p class="text-muted mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-calendar3"></i> 30 January 2026 
                <span class="vr mx-2"></span>
                <span id="live-clock">00:00:00</span>
            </p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('profiles.create') }}" class="btn btn-primary px-4 py-2 rounded-4 shadow-sm fw-bold">
                <i class="bi bi-plus-circle me-2"></i> สร้างบัญชีใหม่
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="stat-card d-flex align-items-center shadow-sm">
                <div class="bg-primary-subtle text-primary p-3 rounded-4 me-3">
                    <i class="bi bi-shield-lock-fill fs-3"></i>
                </div>
                <div>
                    <div class="small text-muted fw-bold">แอดมินทั้งหมด</div>
                    <div class="fs-4 fw-bold counter">{{ $profiles->total() }} ราย</div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="stat-card d-flex align-items-center shadow-sm border-success-subtle">
                <div class="bg-success-subtle text-success p-3 rounded-4 me-3">
                    <i class="bi bi-cpu fs-3"></i>
                </div>
                <div>
                    <div class="small text-muted fw-bold">สถานะเซิร์ฟเวอร์</div>
                    <div class="fs-4 fw-bold text-success">Healthy <div class="dot-active ms-1"></div></div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="stat-card d-flex align-items-center shadow-sm">
                <div class="bg-warning-subtle text-warning p-3 rounded-4 me-3">
                    <i class="bi bi-activity fs-3"></i>
                </div>
                <div>
                    <div class="small text-muted fw-bold">อัปเดตล่าสุด</div>
                    <div class="small fw-bold text-dark">เมื่อไม่กี่วินาทีที่ผ่านมา</div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container shadow-sm" data-aos="fade-up">
        <div class="search-wrapper p-4 bg-white border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="adminSearch" class="form-control search-control" placeholder="ค้นหาแอดมินด้วยชื่อหรืออีเมล...">
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light rounded-3 px-3 border"><i class="bi bi-download me-2"></i>Export</button>
                    <button class="btn btn-light rounded-3 px-3 border"><i class="bi bi-funnel"></i></button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle m-0" id="adminTable">
                <thead>
                    <tr>
                        <th class="ps-4">สมาชิก</th>
                        <th>อีเมลติดต่อ</th>
                        <th>วันที่เข้าใช้งาน</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-end pe-4">เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profiles as $profile)
                    <tr class="admin-row">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $profile->image ? asset('images/' . $profile->image) : 'https://ui-avatars.com/api/?name='.urlencode($profile->name).'&background=4f46e5&color=fff' }}" 
                                     class="user-avatar shadow-sm">
                                <div class="ms-3">
                                    <div class="fw-bold text-dark mb-0">{{ $profile->name }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">ID: #{{ str_pad($profile->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-secondary fw-medium">{{ $profile->email }}</span></td>
                        <td><span class="text-muted small"><i class="bi bi-clock-history me-1"></i>{{ $profile->created_at->format('d/m/Y') }}</span></td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ $profile->is_active ?? true ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3 py-2">
                                <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>
                                {{ $profile->is_active ?? true ? 'ปกติ' : 'ถูกระงับ' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-action-group">
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-light border text-muted" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-light border text-primary" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" id="delete-form-{{ $profile->id }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-light border text-danger" onclick="confirmDelete({{ $profile->id }})">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5">ไม่พบข้อมูลบัญชี</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-light border-top d-flex justify-content-between align-items-center">
            <div class="small text-muted fw-bold">Showing {{ $profiles->count() }} of {{ $profiles->total() }} records</div>
            <div>{!! $profiles->links("pagination::bootstrap-5") !!}</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init();

    // 1. Live Clock
    function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').textContent = now.toLocaleTimeString('th-TH', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. Real-time Search (Client-side)
    document.getElementById('adminSearch').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#adminTable tbody tr.admin-row');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });

    // 3. Delete Confirmation
    function confirmDelete(id) {
        Swal.fire({
            title: 'ต้องการลบแอดมินท่านนี้?',
            text: "ข้อมูลจะถูกลบออกไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#f1f5f9',
            confirmButtonText: '<span style="color:white">ใช่, ลบเลย!</span>',
            cancelButtonText: '<span style="color:#64748b">ยกเลิก</span>',
            customClass: { popup: 'rounded-4' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection