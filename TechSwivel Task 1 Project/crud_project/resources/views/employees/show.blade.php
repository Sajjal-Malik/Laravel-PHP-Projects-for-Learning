@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <h2>Employee Details</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>First Name:</strong> {{ $employee->firstName }}</p>
            <p><strong>Last Name:</strong> {{ $employee->lastName }}</p>
            <p><strong>Email:</strong> {{ $employee->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</p>
            <p><strong>Company:</strong> {{ $employee->company ? $employee->company->name : 'N/A' }}</p>
        </div>
    </div>

    <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Back to List</a>
@endsection