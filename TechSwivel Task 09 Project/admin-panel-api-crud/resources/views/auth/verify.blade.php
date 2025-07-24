@extends('layouts.guest')

@section('title', 'Verify Email')

@push('styles')
<style>
    .verify-card {
        max-width: 550px;
    }

    .verify-icon {
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.6);
    }
    
    
    .alert-success {
        border-radius: 0.5rem;
        border-width: 1px;
        background-color: rgba(25, 135, 84, 0.2);
        color: #d1e7dd;
        border-color: #badbcc;
    }

    
    .btn-link.resend-link {
        color: #a0b2f8;
        text-decoration: underline;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .btn-link.resend-link:hover {
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="glass-card verify-card text-white text-center">
    
    <div class="mb-4">
        <i class="fas fa-envelope-open-text verify-icon"></i>
    </div>
    
    <h2 class="fw-bold mb-3">{{ __('Verify Your Email Address') }}</h4>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <p class="text-white-50">
        {{ __('Before proceeding, please check your inbox for a verification link.') }}
    </p>

    <p class="text-white-50 mt-4 mb-0">
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline resend-link">
                {{ __('click here to request another') }}
            </button>.
        </form>
    </p>

</div>
@endsection