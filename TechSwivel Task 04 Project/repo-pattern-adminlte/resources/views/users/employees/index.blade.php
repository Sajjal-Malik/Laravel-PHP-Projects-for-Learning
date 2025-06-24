@extends('layouts.app')

@section('title', 'Employees')

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
            <h2>Employees</h2>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Create Employee</a>
        </div>

        <table class="table table-bordered" id="employees-table" style="width: 100%">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>First</th>
                    <th>Last</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@push('scripts')
    <script>
        const employeeIndexUrl = "{{ route('employees.index') }}";
    </script>
    <script src="{{ asset('js/employee-script.js') }}"></script>
@endpush
