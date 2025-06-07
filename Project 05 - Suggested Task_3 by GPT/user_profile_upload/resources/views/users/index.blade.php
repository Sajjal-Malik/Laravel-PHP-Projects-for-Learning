@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>User List</h2>
        <button class="btn btn-primary" id="createUserBtn">
            <i class="fa fa-plus"></i> Create User
        </button>
    </div>

    <table class="table table-bordered" id="usersTable">
        <thead class="table-light">
            <tr>
                <th>Profile</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Phone Number</th>
                <th>Bio</th>
                <th>DOB</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    { data: 'profileImage', name: 'profileImage' },
                    { data: 'firstName', name: 'firstName' },
                    { data: 'lastName', name: 'lastName' },
                    { data: 'email', name: 'email' },
                    { data: 'age', name: 'age' },
                    { data: 'phoneNumber', name: 'phoneNumber' },
                    { data: 'bio', name: 'bio' },
                    { data: 'DOB', name: 'DOB' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush