@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary fw-bold">แก้ไขข้อมูลนักเรียน</h5>
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">กลับหน้าหลัก</a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-4 text-center border-end">
                        <div class="mb-3">
                            @if($student->image)
                                <img src="{{ asset('images/' . $student->image) }}" id="preview" class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f8f9fa;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random&size=150" id="preview" class="rounded-circle mb-3 shadow-sm" alt="profile">
                            @endif
                        </div>
                        <p class="text-muted small">ID: #{{ $student->id }}</p>

                        <div class="mt-3 px-5">
                            <label class="form-label text-muted small fw-bold">เปลี่ยนรูปนักเรียน (Student Photo)</label>
                            <input type="file" name="image" class="form-control form-control-sm @error('image') is-invalid @enderror" onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">ชื่อนักเรียน (Name)</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light" value="{{ old('name', $student->name) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">อีเมล (Email)</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" value="{{ old('email', $student->email) }}">
                        </div>
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-success px-4 me-2">Update Data</button>
                            <a href="{{ route('students.index') }}" class="btn btn-light px-4 border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection