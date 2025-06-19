@extends('layouts.app')

@section('content')

    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h2 class="text-white">Users List</h2>
        <a href="{{ route('users.create')}}" class="btn btn-info float-end mb-2">Add New User</a>
        <table class="table table-bordered" id="users-table">
            <thead>
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
@endsection

@push('scripts')
    <script>
        const usersIndexUrl = "{{ route('users.index') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
@endpush