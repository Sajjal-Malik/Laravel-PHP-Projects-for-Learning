@extends('layouts.guest')

@section('title', 'Reset Password Page')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-6">
        <div class="card border border-primary shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ __('Reset Password') }}</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $request->email) }}" required autofocus>

                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>

                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required>
                    </div>

                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
