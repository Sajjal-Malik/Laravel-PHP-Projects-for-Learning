@extends('layouts.app')

@section('title', 'Employees Index Page')

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
            <a href="{{route('employees.create')}}" class="btn btn-primary">Create Employee</a>
        </div>

        <table class="table table-bordered" id="employees-table">
            <thead>
                <tr>
                    <th>Emp Photo</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {

            var table = $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('employees.index') }}',
                columns: [
                    { data: 'empPhoto', name: 'empPhoto' },
                    { data: 'firstName', name: 'firstName' },
                    { data: 'lastName', name: 'lastName' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });

    </script>
@endpush