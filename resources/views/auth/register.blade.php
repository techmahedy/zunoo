@extends('layouts.app')
@section('title', 'Register')
@section('content')
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Register</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @hasflash
                        {!! flash()->display() !!}
                    @endhasflash
                    <form action="{{ route('register.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" aria-describedby="username" required
                                name="username" value="{{ old('username') }}">
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="name" name="name"
                                required value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email"
                                name="email" required value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                aria-describedby="password" required value="{{ old('password') }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg float-start">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
