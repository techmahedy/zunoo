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
                    @hasflash
                        {!! flash()->display() !!}
                    @endhasflash
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" aria-describedby="username"
                                value="{{ Zuno\Auth\Security\Auth::user()->username }}" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="name"
                                value="{{ Zuno\Auth\Security\Auth::user()->name }}" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email"
                                value="{{ Zuno\Auth\Security\Auth::user()->email }}" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Image</label>
                            <input type="file" class="form-control" id="file" aria-describedby="file" name="file">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg float-start">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@append
