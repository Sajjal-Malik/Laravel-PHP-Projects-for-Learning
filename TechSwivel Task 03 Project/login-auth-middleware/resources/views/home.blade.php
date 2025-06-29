@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">Go to Companies List</a>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary me-2">Go to Employees List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
