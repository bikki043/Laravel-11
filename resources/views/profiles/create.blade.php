@extends('profiles.layout')
@include('layouts.navbar')
@section('content')
    <div class="card mt-5">
        <h2 class="card-header">Create New Profile</h2>
        <div class="card-body">
             <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('profiles.index') }}" class="btn btn-success">Back</a>

            </div>
            <form action="{{route("profiles.store")}}" method="post" enctype ="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    name="name" id="name" placeholder="Enter name" value="{{old('name')}}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    name="email" id="email" placeholder="Enter email" value="{{old('email')}}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                 <div class="form-group">
                    <label for="image"><strong>Image</strong></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                    name="image" id="image">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary ">Submit</button>

            </form>

    </div>
@endsection
       