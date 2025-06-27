@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    @if(auth()->user()->role == 2 && !auth()->user()->isBlocked)
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <strong>User Dashboard</strong>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <p class="mb-4"> Hello {{auth()->user()->name}} --- {{ __('You are logged in!') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger m-5 text-center">
            Unauthorized access. Only active users can access this page.
        </div>
    @endif
@endsection
