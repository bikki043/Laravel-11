@extends('layouts.app')

@section('title', 'รายชื่อนักเรียน')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 mt-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-0">รายชื่อนักเรียน</h4>
                    <p class="text-muted small mb-0">จัดการข้อมูลนักเรียนในระบบ</p>
                </div>
                <a href="{{ route('students.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus me-1"></i> เพิ่มข้อมูลนักเรียน
                </a>
            </div>
        </div>

        <div class="card-body px-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0">ชื่อ-นามสกุล</th>
                            <th class="border-0">รหัสนักเรียน</th>
                            <th class="border-0">อีเมลติดต่อ</th>
                            <th class="border-0">วันเข้าสู่ระบบ</th>
                            <th class="text-end pe-4 border-0">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($student->image)
                                            <img src="{{ asset('images/' . $student->image) }}" class="rounded-circle me-3 border" style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=1e293b&color=fff&size=100" class="rounded-circle me-3" style="width: 45px; height: 45px;">
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $student->name }}</div>
                                            <small class="text-muted">นักเรียน</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        S-{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <div class="text-dark">{{ $student->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted text-xs">{{ $student->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-white btn-sm px-3 border-end" title="ดูรายละเอียด">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                        <a href="{{ route('students.edit', $student) }}" class="btn btn-white btn-sm px-3 border-end" title="แก้ไข">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm px-3" onclick="return confirm('ยืนยันการลบข้อมูลนักเรียนท่านนี้หรือไม่?')" title="ลบ">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                    <p class="text-muted fw-bold">ไม่พบข้อมูลนักเรียนในระบบ</p>
                                    <a href="{{ route('students.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">เพิ่มนักเรียนคนแรกเลย</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($students->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .table thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 1.25rem 1rem;
    }
    .btn-white {
        background-color: #fff;
        border: 1px solid #e2e8f0;
    }
    .btn-white:hover {
        background-color: #f8fafc;
    }
    .text-xs { font-size: 0.75rem; }
    .table-hover tbody tr:hover { background-color: #fcfdfe; }
</style>
@endsection