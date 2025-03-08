@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Dashboard</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-start">
                <div class="col-md-8">
                    <p class="fw-bold fs-5">
                        You are logged in as
                        <span class="text-success fw-bold">{{ Zuno\Auth\Security\Auth::user()->email }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

