@extends('layouts.guest')

@section('title', 'Login')

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

    .auth-form .forgot-password-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .auth-form .forgot-password-link:hover {
        color: #ffffff;
    }

    
    .alert {
        border-radius: 0.5rem;
        border-width: 1px;
        background-color: rgba(0,0,0,0.2);
    }
    .alert-danger {
        color: #f8d7da;
        border-color: #f5c6cb;
    }
    .alert-success {
        color: #d1e7dd;
        border-color: #badbcc;
    }
</style>
@endpush

@section('content')
<div class="glass-card auth-form">
    <div class="text-center mb-4">
        <h2 class="text-white fw-bold">Welcome Back!</h2>
        <p class="text-white-50">Sign in to continue</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label text-white-50" for="remember">{{ __('Remember Me') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary" style="width: 40%;">{{ __('Login') }}</button>
            @if (Route::has('password.request'))
                <a class="forgot-password-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>
    </form>
</div>
@endsection