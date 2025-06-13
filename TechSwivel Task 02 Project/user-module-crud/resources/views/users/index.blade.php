@extends('layouts.app') {{-- Make sure you have a layout with @yield('content') --}}

@section('content')

    <div class="container mt-5">
        <h2>User Management</h2>
        <button class="btn btn-primary mb-3 float-end" id="createUserBtn">Create User</button>

        <table class="table table-bordered" id="userTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Phone Number</th>
                    <th>Bio</th>
                    <th>DOB</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    @include('users.partials.user-modal')

    @include('users.partials.view-modal')

@endsection


@push('scripts')

    <script>
        const usersIndexUrl = "{{ route('users.index') }}";
    </script>

    <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>

@endpush