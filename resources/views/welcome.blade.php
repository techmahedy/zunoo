@extends('layouts.app')
@section('title') Welcome
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 65vh;">
        <div class="content text-center">
            <p>Thank you for choosing Zuno {{ \Zuno\Application::VERSION }}. Build something amazing!</p>
            <div class="buttons">
                <a href="https://github.com/techmahedy/zunoo" class="btn btn-light">Github</a>
                <a href="https://github.com/techmahedy/zunoo" class="btn btn-light">Documentation</a>
            </div>
        </div>
    </div>
@endsection