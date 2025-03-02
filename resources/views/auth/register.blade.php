@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Register</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Showing All Error Messages -->
                    @if (session()->has('errors'))
                        @foreach (session()->get('errors') as $error)
                            @foreach ($error as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        @endforeach
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>{{ session()->get('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('register.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" aria-describedby="username" required
                                name="username" value="{{ old('username') }}">
                            @if (session()->has('username'))
                                <span class="text-danger"> {{ session()->get('username') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" aria-describedby="first_name"
                                name="first_name" required value="{{ old('first_name') }}">
                            @if (session()->has('first_name'))
                                <span class="text-danger"> {{ session()->get('first_name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" aria-describedby="emailHelp"
                                name="last_name" required value="{{ old('last_name') }}">
                            @if (session()->has('last_name'))
                                <span class="text-danger"> {{ session()->get('last_name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email"
                                name="email" required value="{{ old('email') }}">
                            @if (session()->has('email'))
                                <span class="text-danger"> {{ session()->get('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                aria-describedby="password" required value="{{ old('password') }}">
                            @if (session()->has('password'))
                                <span class="text-danger"> {{ session()->get('password') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg float-start">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
