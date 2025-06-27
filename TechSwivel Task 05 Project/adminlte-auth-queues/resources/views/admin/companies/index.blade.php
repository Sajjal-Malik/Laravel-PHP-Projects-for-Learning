@extends('layouts.app')

@section('title', 'Companies Index Page')

@section('content')
    
    @if(session('success'))
        <div class="alert alert-success mt-2 success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-2 error-message">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Companies</h2>
            <a href="{{ route('companies.create') }}" class="btn btn-primary">
                Create Company
            </a>
        </div>

        {!! $dataTable->table(['class' => 'table table-bordered w-100'], true) !!}

    </div>
@endsection

@push('scripts')
    
    {!! $dataTable->scripts() !!}

@endpush
