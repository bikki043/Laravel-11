@extends('layouts.app')

@section('title', 'รายชื่อคุณครู')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 mt-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">รายชื่อบุคลากร</h4>
                    <p class="text-muted small mb-0">จัดการข้อมูลคุณครูและเจ้าหน้าที่ในระบบ</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('teachers.pdf') }}" class="btn btn-danger rounded-pill px-4 shadow-sm">
                        <i class="fas fa-file-pdf me-1"></i> ออกรายงาน PDF
                    </a>
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus me-1"></i> เพิ่มข้อมูลครู
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0">ชื่อ-นามสกุล</th>
                            <th class="border-0">รหัสพนักงาน</th>
                            <th class="border-0">อีเมลติดต่อ</th>
                            <th class="border-0">วันที่เริ่มงาน</th>
                            <th class="text-end pe-4 border-0">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($teacher->image)
                                            <img src="{{ asset('images/' . $teacher->image) }}" class="rounded-circle me-3 border" style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=1e293b&color=fff&size=100" class="rounded-circle me-3" style="width: 45px; height: 45px;">
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $teacher->name }}</div>
                                            <small class="text-muted">อาจารย์ผู้สอน</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        T-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>{{ $teacher->email }}</td>
                                <td>
                                    <div class="text-dark">{{ $teacher->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted text-xs">{{ $teacher->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                        <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-white btn-sm px-3 border-end">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-white btn-sm px-3 border-end">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm px-3" onclick="return confirm('ยืนยันการลบข้อมูลครู?')">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted fw-bold">ไม่พบข้อมูลคุณครูในระบบ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($teachers->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $teachers->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<style>
    .table thead th { font-weight: 700; text-transform: uppercase; font-size: 0.75rem; color: #64748b; padding: 1.25rem 1rem; }
    .btn-white { background-color: #fff; border: 1px solid #e2e8f0; }
    .text-xs { font-size: 0.75rem; }
</style>
@endsection