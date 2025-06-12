@extends('layouts.app')

@section('title', 'Create Company')

@section('content')

    <div class="card">

        <div class="card-header">Create new Company</div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

             <form action="{{ route('companies.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Comapny Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email (optional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website (optional)</label>
                    <input type="url" name="website" id="website" value="{{ old('website') }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Create</button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>

    </div>

@endsection
