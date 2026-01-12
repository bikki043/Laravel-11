@extends('profiles.layout')
@include('layouts.navbar')
@section('content')
    <div class="card mt-5">
        <h2 class="card-header">Show Profile</h2>
        <div class="card-body">
            <table class="table table-striped mt-4">
                <tbody>
                    <tr>
                        <td><strong>ID</strong></td>
                        <td>{{ $profile->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{{ $profile->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $profile->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Image</strong></td>
                        <td><img src="{{ asset('images/' . $profile->image) }}" alt="Image" width="100"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection