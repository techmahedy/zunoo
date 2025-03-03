@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Your profile {{ ucfirst($username) }}</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (flash()->hasMessages())
                        {!! flash()->display() !!}
                    @endif
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" aria-describedby="username"
                                value="{{ Zuno\Auth\Security\Auth::user()->username }}" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" aria-describedby="first_name"
                                value="{{ Zuno\Auth\Security\Auth::user()->first_name }}" name="first_name">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" aria-describedby="emailHelp"
                                value="{{ Zuno\Auth\Security\Auth::user()->last_name }}" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email"
                                value="{{ Zuno\Auth\Security\Auth::user()->email }}" readonly disabled>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg float-start">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
