@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="card shadow w-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create New Order</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('admin.orders.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="riderId">Select Rider</label>
                            <select name="riderId" id="riderId" class="form-control @error('riderId') is-invalid @enderror"
                                required>
                                <option value="">-- Select Rider --</option>
                                @foreach($riders as $rider)
                                    <option value="{{ $rider->id }}" {{ old('riderId') == $rider->id ? 'selected' : '' }}>
                                        {{ $rider->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('riderId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="customerId">Select Customer</label>
                            <select name="customerId" id="customerId"
                                class="form-control @error('customerId') is-invalid @enderror" required>
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customerId') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customerId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">Order Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success">Create Order</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection