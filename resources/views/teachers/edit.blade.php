@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary fw-bold">แก้ไขข้อมูลครู</h5>
            <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-secondary">กลับหน้าหลัก</a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-4 text-center border-end">
                        <img src="https://ui-avatars.com/api/?name={{ $teacher->name }}&background=random&size=150" class="rounded-circle mb-3 shadow-sm" alt="profile">
                        <p class="text-muted">ID: #{{ $teacher->id }}</p>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">ชื่อนักเรียน (Name)</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light" value="{{ $teacher->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">อีเมล (Email)</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" value="{{ $teacher->email }}">
                        </div>
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-success px-4 me-2">Update Data</button>
                            <a href="{{ route('teachers.index') }}" class="btn btn-light px-4 border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection