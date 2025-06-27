@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
<style>
    .login-wrapper {
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-card {
        width: 100%;
        max-width: 500px;
        background-color: #ffffff;
    }
    button.btn-primary { width: 40%; }
</style>
@endpush

@section('content')
<div class="container login-wrapper">
    <div class="card login-card shadow border border-light">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ __('Login') }}</h5>
        </div>

        <div class="card-body bg-white">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('Username') }}</label>
                    <input id="username" type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           name="username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember"
                           class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>

                    @if (Route::has('password.request'))
                        <a class="text-muted" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
