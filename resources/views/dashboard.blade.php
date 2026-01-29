@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Overview')





@section('content')
<div class="container-fluid py-4">
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 fw-bold mb-0">{{ number_format($totalStudents) }}</div>
                            <div class="small opacity-75">Total Students</div>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-user-graduate"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 fw-bold mb-0">{{ number_format($totalTeachers) }}</div>
                            <div class="small opacity-75">Total Teachers</div>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-chalkboard-teacher"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 fw-bold mb-0">{{ number_format($totalUsers) }}</div>
                            <div class="small opacity-75">Total Users</div>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-users-cog"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 fw-bold mb-0">{{ number_format($totalProfiles) }}</div>
                            <div class="small opacity-75">Profiles Linked</div>
                        </div>
                        <div class="fs-1 opacity-50"><i class="fas fa-id-card"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-user-graduate me-2 text-primary"></i>Recent Students</h6>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-muted small">
                                <tr>
                                    <th>Student</th>
                                    <th>Joined Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentStudents as $student)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($student->image)
                                                    <img src="{{ asset('images/'.$student->image) }}" class="rounded-circle me-3" width="35" height="35" style="object-fit: cover;">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=E3F2FD&color=0D47A1" class="rounded-circle me-3" width="35">
                                                @endif
                                                <div>
                                                    <div class="fw-bold mb-0 small">{{ $student->name }}</div>
                                                    <div class="text-muted" style="font-size: 11px;">{{ $student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="small text-muted">{{ $student->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center py-4 text-muted">No students found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-chalkboard-teacher me-2 text-success"></i>Recent Teachers</h6>
                    <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-muted small">
                                <tr>
                                    <th>Teacher</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTeachers as $teacher)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($teacher->image)
                                                    <img src="{{ asset('images/'.$teacher->image) }}" class="rounded-circle me-3" width="35" height="35" style="object-fit: cover;">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=F1F8E9&color=33691E" class="rounded-circle me-3" width="35">
                                                @endif
                                                <div>
                                                    <div class="fw-bold mb-0 small">{{ $teacher->name }}</div>
                                                    <div class="text-muted" style="font-size: 11px;">{{ $teacher->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3" style="font-size: 10px;">Active</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center py-4 text-muted">No teachers found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection