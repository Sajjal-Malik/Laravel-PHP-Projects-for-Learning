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

            $('#createUserBtn').click(function () {
                $.ajax({
                    url: "{{ route('users.create') }}",
                    method: "GET",
                    success: function (response) {
                        // Remove existing modal if present
                        $('#userModal').modal('hide');

                        // Append new HTML modal and show it
                        $('body').append(response);
                        $('#userModal').modal('show');
                    },
                    error: function (error) {
                        alert("Failed to load the form");
                    }
                });
            });

            $('#userForm').on('submit', function (e) {
                e.preventDefault(); // 🔐 This stops normal browser form submission

                let form = this;
                let formData = new FormData(form);

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                $.ajax({
                    method: 'POST',
                    url: "{{ route('users.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#userModal').modal('hide');
                        $('#userForm')[0].reset();
                        $('#usersTable').DataTable().ajax.reload(null, false);
                        alert(response.message);
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                let input = $('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                            });
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    }
                });
            });
        });
    </script>

@endpush