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

        <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <p><small><span class="text-danger">*</span> Required fields</small></p>

            <div class="mb-3">
                <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
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

            <div class="mb-3">
                <label for="logo" class="form-label">Company Logo (optional)</label>
                <input type="file" name="logo" id="logo" class="form-control">
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
