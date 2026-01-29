@extends('profiles.layout')
@include('layouts.navbar')
@section('content')
    <div class="card mt-5">
        <h2 class ="card-header">ผู้ดูเเลระบบ</h2>
        <div class ="card-body">
            @session('sussess')
                <div class="alert alert-success" role="alert">{{ session('sussess') }}</div>
            @endsession


            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('profiles.create') }}" class="btn btn-success">Create New Profile</a>

            </div>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Detail</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse  ($profiles as $profile)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->email }}</td>
                        <td>
                            <img src="{{ asset('images/' . $profile->image) }}" alt="image" width="100">
                        </td>
                        <td>
                            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST">
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>   
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No Data!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $profiles->links("pagination::bootstrap-5") !!}
        </div>    
    </div>
@endsection