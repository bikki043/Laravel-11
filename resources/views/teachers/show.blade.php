@extends('layouts.app')

@section('content')
<div class="container">
    <h1>รายละเอียดครู</h1>
    <p>ชื่อ: {{ $teacher->name }}</p>
    <p>รหัส: {{ $teacher->student_id }}</p> {{-- สังเกตจาก JSON parameter ของคุณใช้ชื่อนี้ --}}
</div>
@endsection