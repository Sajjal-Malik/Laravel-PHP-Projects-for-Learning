@extends('layouts.app')

@section('title', 'Profiles')

<style>
    /* Note: Consider using Bootstrap's margin utilities like 'ms-auto' for better responsiveness*/
    .profile-btn{
        margin-left: auto;
    }

     /* --- PARSLEY VALIDATION STYLES --- */

    /* Style for fields with validation errors */
    .parsley-error {
        border-color: #dc3545 !important;
    }

    /* Style for the error message text */
    .parsley-errors-list {
        color: #dc3545;
        margin-top: 5px;
        padding-left: 0;
        list-style: none;
        font-size: 0.9em;
    }

    /* Style for successfully validated fields (Optional but good for UX) */
    .parsley-success {
        border-color: #198754 !important;
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Profiles List</h4>
                <button class="btn btn-success btn-sm profile-btn" id="addNewProfileBtn">+ Add Profile</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="profiles-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Picture</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Age Status</th>
                            <th>Phone</th>
                            <th>Bio</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    @include('admin.profiles.profile-modal')

    @include('admin.profiles.view-modal')

@endsection

@push('scripts')

    <script>
        const profileIndexUrl = "{{ route( 'profiles.index' ) }}";
    </script>

    <script src="{{ asset('js/profile.js') }}"></script>

@endpush