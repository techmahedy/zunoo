@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Login</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @hasflash
                        {!! flash()->display() !!}
                    @endhasflash
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                aria-describedby="email" placeholder="Enter your email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="alert alert-danger mt-1 p-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" placeholder="Enter your password" name="password"
                                value="{{ old('password') }}">
                            @error('password')
                                <div class="alert alert-danger mt-1 p-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg float-start">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
