@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
<div class="container-fluid">
    <h4>Add New Customer</h4>

    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Rider</label>
            <select name="riderId" class="form-control" required>
                <option value="">-- Select Rider --</option>
                @foreach($riders as $rider)
                    <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                @endforeach
            </select>
            @error('riderId') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Create Customer</button>
    </form>
</div>
@endsection
