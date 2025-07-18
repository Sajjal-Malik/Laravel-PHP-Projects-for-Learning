@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @if(auth()->user()->role === 1)
        <div class="container-fluid">

            <div class="row lg-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Admin Dashboard</h4>
                        </div>
                        <div class="card-body">
                            <p class="lead">Welcome, {{ auth()->user()->name }}!</p>
                            <p>You have full access to the system.</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5>Total Orders</h5>
                        @php
                            $count = App\Models\Order::count();
                        @endphp
                        <h2>{{$count}}</h2>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.riders.index') }}" class="btn btn-outline-primary w-100">Manage Riders</a>
            </div>
            {{-- <div class="col-md-3 mb-3">
                <a href="{{ route('riders.notifications-panel') }}" class="btn btn-outline-dark w-100">Rider Notifications</a>
            </div> --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-success w-100">Manage Customers</a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning w-100">Manage Orders</a>
            </div>
        </div>
        </div>
    @else
        <div class="alert alert-danger m-5 text-center">
            Unauthorized access. Only admins can access this page.
        </div>
    @endif
@endsection