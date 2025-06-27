@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-6">
        <div class="card border border-info shadow">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">{{ __('Verify Your Email Address') }}</h4>
            </div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                <p class="mb-0">
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('click here to request another') }}
                        </button>.
                    </form>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
