@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
<div class="container mt-4">
    <h2>Create New Employee</h2>

     @if(session('success'))
        <div class="alert alert-success mt-2 success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-2 error-message">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <p><small><span class="text-danger">*</span> Required fields</small></p>

        <div class="mb-3">
            <label for="firstName" class="form-label">First Name<span class="text-danger">*</span></label>
            <input type="text" name="firstName" id="firstName" class="form-control" value="{{ old('firstName') }}" required>
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name<span class="text-danger">*</span></label>
            <input type="text" name="lastName" id="lastName" class="form-control" value="{{ old('lastName') }}" required>
        </div>

        <div class="mb-3">
            <label for="userName" class="form-label">Username<span class="text-danger">*</span></label>
            <input type="text" name="userName" id="userName" class="form-control" value="{{ old('userName') }}" required>
        </div>

        <div class="mb-3">
            <label for="companyId" class="form-label">Company</label>
            <select name="companyId" id="companyId" class="form-select">
                <option value="">-- Select Company --</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('companyId') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (optional)</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone (optional)</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="empPhoto" class="form-label">Photo<span class="text-danger">*</span></label>
            <input type="file" name="empPhoto" id="empPhoto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Create Employee</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
