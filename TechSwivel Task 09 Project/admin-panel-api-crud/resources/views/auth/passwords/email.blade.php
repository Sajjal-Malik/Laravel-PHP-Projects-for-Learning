@extends('layouts.guest')

@section('title', 'Forgot Password')

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

    .auth-form .form-control:focus {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: #ffffff;
        color: #ffffff;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.35);
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
    
    .alert-success {
        border-radius: 0.5rem;
        border-width: 1px;
        background-color: rgba(25, 135, 84, 0.2);
        color: #d1e7dd;
        border-color: #badbcc;
    }
</style>
@endpush

@section('content')
<div class="glass-card auth-form">
    <div class="text-center mb-4">
        <h2 class="text-white fw-bold">Forgot Your Password?</h2>
        <p class="text-white-50">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>
    
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        
        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
</div>
@endsection