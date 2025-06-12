@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<h2>Edit Employee</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="firstName" id="firstName" class="form-control" value="{{ old('firstName', $employee->firstName) }}" required>
    </div>

    <div class="mb-3">
        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="lastName" id="lastName" class="form-control" value="{{ old('lastName', $employee->lastName) }}" required>
    </div>

    <div class="mb-3">
        <label for="companyId" class="form-label">Company</label>
        <select name="companyId" id="companyId" class="form-select">
            <option value="">-- Select Company --</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ old('companyId', $employee->companyId) == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $employee->email) }}">
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
    </div>

    <button type="submit" class="btn btn-primary">Update Employee</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
