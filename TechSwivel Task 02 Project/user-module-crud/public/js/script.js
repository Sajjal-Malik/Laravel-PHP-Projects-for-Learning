 $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let userTable = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: usersIndexUrl,
                columns: [
                    { data: 'firstName' },
                    { data: 'lastName' },
                    { data: 'email' },
                    { data: 'age' },
                    { data: 'phoneNumber' },
                    { data: 'bio' },
                    { data: 'dob' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#createUserBtn').click(function () {
                $('#userForm')[0].reset();
                $('#userForm').attr('data-parsley-validate', '');
                $('#userModalTitle').text('Create User');
                $('#user_id').val('');
                $('#userModal').modal('show');
            });

            $('#userForm').on('submit', function (e) {
                e.preventDefault();

                if (!$(this).parsley().isValid()) return;

                let id = $('#user_id').val();
                let method = id ? 'PUT' : 'POST';
                let url = id ? `/users/${id}` : `/users`;
                let successMessage = id ? 'User Edited Successfully' : 'User Created Successfully';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function (res) {
                        $('#userModal').modal('hide');
                        userTable.ajax.reload();

                        Swal.fire({ title: 'Success!', text: successMessage, icon: 'success' });
                    },
                    error: function (err) {
                        Swal.fire({ title: 'Error!', text: err.responseJSON?.message, icon: 'error' });
                    }
                });
            });



            $(document).on('click', '.viewUser', function () {

                let id = $(this).data('id');

                $.get(`/users/${id}/edit`, function (data) {

                    $('#viewUserModal .modal-body').html(`
                            <p><strong>First Name:</strong> ${data.firstName}</p>
                            <p><strong>Last Name:</strong> ${data.lastName}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Age:</strong> ${data.age}</p>
                            <p><strong>Phone:</strong> ${data.phoneNumber}</p>
                            <p><strong>Bio:</strong> ${data.bio}</p>
                            <p><strong>DOB:</strong> ${data.dob}</p>`);

                    $('#viewUserModal').modal('show');

                });
            });


            $(document).on('click', '.editUser', function () {

                let id = $(this).data('id');

                $.get(`/users/${id}/edit`, function (data) {

                    $('#userModalTitle').text('Edit User');

                    $('#user_id').val(data.id);
                    $('#firstName').val(data.firstName);
                    $('#lastName').val(data.lastName);
                    $('#email').val(data.email).prop('readonly', true);
                    $('#password').val('');
                    $('#age').val(data.age);
                    $('#phoneNumber').val(data.phoneNumber);
                    $('#bio').val(data.bio);
                    $('#dob').val(data.dob);

                    $('#userModal').modal('show');

                });
            });


            $(document).on('click', '.deleteUser', function () {

                if (!confirm("Are you sure you want to delete this user?"))
                    return;

                let id = $(this).data('id');

                $.ajax({
                    url: `/users/${id}`,
                    type: 'DELETE',
                    success: function (res) {
                        userTable.ajax.reload();
                        Swal.fire({ title: 'Success!', text: 'User Deleted Successfully', icon: 'success' });
                    },
                    error: function (err) {
                        Swal.fire({ title: 'Error!', text: err.responseJSON?.message, icon: 'error' });
                    }
                });
            });
        });