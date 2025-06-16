@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')

    <div class="card">

        <div class="card-header">Edit Company</div>
        
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Add enctype for file upload --}}
            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Company Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email (optional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $company->email) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website (optional)</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $company->website) }}" class="form-control">
                </div>

                {{-- Show existing logo if available --}}
                @if ($company->logo)
                    <div class="mb-2">
                        <label class="form-label">Current Logo:</label><br>
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" height="100">
                    </div>
                @endif

                {{-- Logo Upload --}}
                <div class="mb-3">
                    <label for="logo" class="form-label">Change Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Min size: 100x100px | Max file: 2MB</small>
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>

@endsection
