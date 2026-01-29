@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $totalStudents }}</div>
        <div class="stat-label">Total Students</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $totalTeachers }}</div>
        <div class="stat-label">Total Teachers</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $totalProfiles }}</div>
        <div class="stat-label">Total Profiles</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <!-- Recent Students -->
    <div class="card">
        <div class="card-header">
            Recent Students
            <a href="{{ route('students.index') }}" style="float: right; font-size: 12px; color: #3b82f6;">View All</a>
        </div>
        <div class="card-body">
            @if($recentStudents->count())
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentStudents as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #9ca3af;">No students yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Teachers -->
    <div class="card">
        <div class="card-header">
            Recent Teachers
            <a href="{{ route('teachers.index') }}" style="float: right; font-size: 12px; color: #3b82f6;">View All</a>
        </div>
        <div class="card-body">
            @if($recentTeachers->count())
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTeachers as $teacher)
                            <tr>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->student_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #9ca3af;">No teachers yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
