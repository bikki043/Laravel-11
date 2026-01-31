@extends('layouts.app')

@section('title', 'จัดการข้อมูลคณาจารย์')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    body { font-family: 'Prompt', sans-serif; background-color: #f8fafc; }
    
    /* Header & Action Buttons */
    .page-header {
        background: white;
        border-radius: 30px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        margin-bottom: 2rem;
    }

    /* Main Table Card */
    .main-card {
        border: none;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        background: white;
    }
    
    .table thead th {
        background-color: #fcfcfd;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 1.5rem 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Search Input Style */
    .search-wrapper { position: relative; }
    .search-input {
        border-radius: 15px;
        padding-left: 45px;
        background-color: #f1f5f9;
        border: 2px solid transparent;
        height: 48px;
        transition: all 0.3s;
    }
    .search-input:focus {
        background-color: white;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }
    .search-icon {
        position: absolute;
        left: 18px;
        top: 14px;
        color: #94a3b8;
    }

    /* Teacher Avatar */
    .teacher-avatar {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .teacher-avatar:hover { transform: scale(1.1) rotate(5deg); }

    /* Department Badge */
    .badge-dept {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    /* Buttons */
    .btn-emerald {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 10px 24px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-emerald:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);
        color: white;
    }

    /* Action Buttons */
    .action-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin: 0 3px;
        transition: all 0.2s;
        border: 1px solid #f1f5f9;
        background: white;
        text-decoration: none;
    }
    .btn-view { color: #4f46e5; }
    .btn-view:hover { background: #eef2ff; transform: translateY(-3px); }
    .btn-edit { color: #d97706; }
    .btn-edit:hover { background: #fffbeb; transform: translateY(-3px); }
    .btn-delete { color: #dc2626; border: none; }
    .btn-delete:hover { background: #fef2f2; transform: translateY(-3px); }
</style>

<div class="container py-5 animate__animated animate__fadeIn">
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fas fa-chalkboard-teacher me-2 text-success"></i> ระบบจัดการคณาจารย์
            </h2>
            <p class="text-muted mb-0">
                บุคลากรทั้งหมดในระบบ <span class="badge bg-dark rounded-pill">{{ $teachers->total() }}</span> ท่าน
            </p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ route('teachers.export-pdf') }}" class="btn btn-outline-danger rounded-pill px-4 shadow-sm" target="_blank">
                <i class="fas fa-file-pdf me-2"></i> PDF
            </a>
            <a href="{{ route('teachers.create') }}" class="btn btn-emerald shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> เพิ่มอาจารย์ใหม่
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__backInDown" style="border-radius: 20px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card main-card">
        <div class="card-header bg-white py-4 px-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <form action="{{ route('teachers.index') }}" method="GET" class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="form-control search-input" placeholder="ค้นหาชื่อ, รหัสอาจารย์ หรือกลุ่มสาระ..." value="{{ request('search') }}">
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ข้อมูลอาจารย์</th>
                        <th>กลุ่มสาระ / ตำแหน่ง</th>
                        <th>การติดต่อ</th>
                        <th>วันที่เริ่มงาน</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    @if($teacher->image)
                                        <img src="{{ asset('images/' . $teacher->image) }}" class="teacher-avatar me-3">
                                    @else
                                        <img src="it67.jpg={{ urlencode($teacher->name) }}&background=10b981&color=fff&rounded=true" class="teacher-avatar me-3">
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $teacher->name }}</div>
                                    <code class="text-success small" style="font-size: 0.75rem;">ID: {{ $teacher->teacher_id }}</code>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-dept mb-1 d-inline-block">{{ $teacher->department ?: 'ทั่วไป' }}</span>
                            <div class="small text-muted fw-light">{{ $teacher->position ?: 'อาจารย์ผู้สอน' }}</div>
                        </td>
                        <td>
                            <div class="small"><i class="far fa-envelope text-muted me-1"></i> {{ $teacher->email }}</div>
                            <div class="small text-muted"><i class="fas fa-phone-alt text-muted me-1" style="font-size: 0.7rem;"></i> {{ $teacher->phone ?: '-' }}</div>
                        </td>
                        <td>
                            <div class="small text-dark fw-500">{{ \Carbon\Carbon::parse($teacher->start_date)->isoFormat('D MMM YYYY') }}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">({{ \Carbon\Carbon::parse($teacher->start_date)->diffForHumans() }})</small>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('teachers.show', $teacher->id) }}" class="action-btn btn-view" title="ดูโปรไฟล์">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="action-btn btn-edit" title="แก้ไข">
                                    <i class="fas fa-pen-nib"></i>
                                </a>
                                <button type="button" class="action-btn btn-delete" onclick="confirmDelete('{{ $teacher->id }}', '{{ $teacher->name }}')" title="ลบ">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $teacher->id }}" action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="animate__animated animate__fadeIn">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 100px; opacity: 0.2;" class="mb-3">
                                <h5 class="text-muted fw-light">ไม่พบข้อมูลรายชื่ออาจารย์</h5>
                                <a href="{{ route('teachers.create') }}" class="btn btn-sm btn-emerald mt-2">เพิ่มข้อมูลตอนนี้</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 py-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-muted small mb-3 mb-md-0">
                    แสดงหน้า {{ $teachers->currentPage() }} จากทั้งหมด {{ $teachers->lastPage() }}
                </div>
                <div>
                    {{ $teachers->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: `คุณกำลังจะลบข้อมูลของ "${name}" ซึ่งไม่สามารถกู้คืนได้`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก',
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection