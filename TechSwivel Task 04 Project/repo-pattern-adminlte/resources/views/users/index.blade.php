@extends('layouts.app')

@section('title', 'Users List')

@section('content')

    <div class="container mt-3">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Users</h3>
            <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" id="users-table" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const usersIndexUrl = "{{ route('users.index') }}";
    </script>
    <script src="{{ asset('js/user-script.js') }}"></script>
@endpush