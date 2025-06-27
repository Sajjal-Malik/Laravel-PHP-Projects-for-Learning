@extends('layouts.app') 

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-6">
        <div class="card border border-primary shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Register New User</h4>
            </div>

            <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Validation failed:</strong>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="row g-2 mb-3">
                        <div class="col">
                            <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input id="firstName" type="text"
                                   class="form-control @error('firstName') is-invalid @enderror"
                                   name="firstName" value="{{ old('firstName') }}" required>
                            @error('firstName')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col">
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
                        <label for="userName" class="form-label">Username <span class="text-danger">*</span></label>
                        <input id="userName" type="text"
                               class="form-control @error('userName') is-invalid @enderror"
                               name="userName" value="{{ old('userName') }}" required>
                        @error('userName')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
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
                            Register
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
