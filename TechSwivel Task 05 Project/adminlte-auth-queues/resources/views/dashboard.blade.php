@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @if(auth()->user()->role === 1)
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Admin Dashboard</h4>
                        </div>
                        <div class="card-body">
                            <p class="lead">Welcome, {{ auth()->user()->name }}!</p>

                            <p>You have full access to the system. You can manage:</p>
                            <ul>
                                <li><strong>Users</strong> — View, create, block/unblock users</li>
                                <li><strong>Companies</strong> — Add/edit company details and logos</li>
                                <li><strong>Employees</strong> — Manage employee information</li>
                            </ul>

                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                                Go to User Management
                            </a>
                            <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">
                                Go to Company Management
                            </a>
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-success">
                                Go to Employee Management
                            </a>
                        </div>
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
