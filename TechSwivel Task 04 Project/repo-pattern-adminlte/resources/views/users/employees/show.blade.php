@extends('layouts.app')

@section('title', 'View Employee')

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Employee Details</h5>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">First Name</dt>
                <dd class="col-sm-9">{{ $employee->firstName }}</dd>

                <dt class="col-sm-3">Last Name</dt>
                <dd class="col-sm-9">{{ $employee->lastName }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $employee->email ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Phone</dt>
                <dd class="col-sm-9">{{ $employee->phone ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Company</dt>
                <dd class="col-sm-9">{{ $employee->company?->name ?? 'N/A' }}</dd>

                @if ($employee->empPhoto)
                    <dt class="col-sm-3">Photo</dt>
                    <dd class="col-sm-9">
                        <img src="{{ asset('storage/' . $employee->empPhoto) }}" alt="Employee Photo" width="120" class="img-thumbnail">
                    </dd>
                @endif
            </dl>

            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

</div>
@endsection
