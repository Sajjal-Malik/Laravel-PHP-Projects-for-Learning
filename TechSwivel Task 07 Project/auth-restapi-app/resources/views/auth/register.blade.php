@extends('layouts.guest')

@section('title', 'Register')

@push('styles')
<style>
    
    .auth-form .form-label {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    .auth-form .form-control {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        border-radius: 0.5rem;
        padding: 0.8rem 1rem;
    }
    
    .auth-form .form-control:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 30px #343a40 inset !important;
        -webkit-text-fill-color: #ffffff !important;
    }

    .auth-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .auth-form .form-control:focus {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: #ffffff;
        color: #ffffff;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.35);
    }

    .auth-form .form-control.is-invalid {
        border-color: #e3342f;
    }
    
    .auth-form .invalid-feedback {
       
        color: #f8d7da; 
    }

    .auth-form .btn-primary {
        background: #667eea;
        border-color: #667eea;
        transition: all 0.3s ease;
        padding: 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
    }

    .auth-form .btn-primary:hover {
        background: #5a6fd5;
        border-color: #5a6fd5;
        transform: translateY(-2px);
    }
    
    
    .alert-danger {
        border-radius: 0.5rem;
        border-width: 1px;
        background-color: rgba(220, 53, 69, 0.2);
        color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>
@endpush

@section('content')
<div class="glass-card auth-form">
    <div class="text-center mb-4">
        <h2 class="text-white fw-bold">Create an Account</h2>
        <p class="text-white-50">Join us today! It's free and only takes a minute.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                <input id="firstName" type="text"
                       class="form-control @error('firstName') is-invalid @enderror"
                       name="firstName" value="{{ old('firstName') }}" required>
                @error('firstName')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input id="lastName" type="text"
                       class="form-control @error('lastName') is-invalid @enderror"
                       name="lastName" value="{{ old('lastName') }}" required>
                @error('lastName')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required>
            @error('password')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input id="password_confirmation" type="password"
                   class="form-control" name="password_confirmation" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
@endsection