@extends('layouts.app')

@section('title', 'Teachers')
@section('breadcrumb', 'Teachers Management')

@section('content')
<div class="card">
    <div class="card-header">
        Teachers List
        <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm" style="float: right;">
            <i class="fas fa-plus"></i> Add Teacher
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->student_id }}</td>
                        <td>{{ $teacher->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #9ca3af;">No teachers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection
