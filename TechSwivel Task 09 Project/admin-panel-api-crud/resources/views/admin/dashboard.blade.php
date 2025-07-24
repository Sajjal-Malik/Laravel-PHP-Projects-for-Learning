@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @if(auth()->user()->role === 1)
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Admin Dashboard</h4>
                        </div>
                        <div class="card-body">
                            <p class="lead">Welcome, {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}!</p>
                            <p>You have full access to the system.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h4>Total Profiles</h4>
                        <h2>{{ $totalProfiles }}</h2>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="alert alert-danger m-5 text-center">
            Unauthorized access. Only admins can access this page.
        </div>
    @endif
@endsection