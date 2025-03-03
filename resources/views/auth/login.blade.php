@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Login</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (flash()->hasMessages())
                        {!! flash()->display() !!}
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email"
                                placeholder="Enter your email" name="email" value="{{ old('email') }}">
                            @if (flash()->has('email'))
                                <span class="text-danger"> {{ flash()->get('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password"
                                name="password" value="{{ old('password') }}">
                            @if (flash()->has('password'))
                                <span class="text-danger"> {{ flash()->get('password') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg float-start">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
