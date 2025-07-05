@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
@if(auth()->user()->role === 1)
    <div class="container-fluid">

        <div class="row mb-4">
            
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Users</h5>
                        <h2 class="fw-bold">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Posts</h5>
                        <h2 class="fw-bold">{{ $totalPosts }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card text-white bg-info shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Comments</h5>
                        <h2 class="fw-bold">{{ $totalComments }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Admin Dashboard</h4>
            </div>
            <div class="card-body">
                <p class="lead">Welcome, {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}!</p>
                <p>You have full access to the system.</p>
            </div>
        </div>

    </div>
@else
    <div class="alert alert-danger m-5 text-center">
        Unauthorized access. Only admins can access this page.
    </div>
@endif
@endsection
