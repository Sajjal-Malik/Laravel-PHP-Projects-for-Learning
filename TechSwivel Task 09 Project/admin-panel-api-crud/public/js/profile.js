$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const userTable = $('#profiles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: profileIndexUrl,
        columns: [
            { data: 'id' },
            { data: 'picture' },
            { data: 'fullName' },
            { data: 'email' },
            { data: 'dob' },
            { data: 'gender' },
            { data: 'age' },
            { data: 'ageStatus' },
            { data: 'phoneNumber' },
            { data: 'bio' },
            { data: 'action' }
        ]
    });

    $('#addNewProfileBtn').click(function () {
        $('#profileForm')[0].reset();
        $('#profileForm').parsley().reset();
        $('#profileModalLabel').text('Create Profile');
        $('#profileId').val('');
        $('#email').prop('readonly', false);
        $('#profileModal').modal('show');
    });

    $(document).on('click', '.editProfileBtn', function () {
        let id = $(this).data('id');

        $.get(`/admin/profiles/${id}/edit`, function (response) {
            let data = response.data;

            $('#profileModalLabel').text('Edit Profile');
            $('#profileId').val(id); // assuming you're using hidden input
            $('#firstName').val(data.firstName);
            $('#lastName').val(data.lastName);
            $('#email').val(data.email).prop('readonly', true);
            $('#dob').val(data.dob);
            $('#age').val(data.age);
            $('#gender').val(data.gender);
            $('#phoneNumber').val(data.phoneNumber);
            $('#bio').val(data.bio);
            $('#profileModal').modal('show');
        });
    });

    $('#profileForm').on('submit', function (event) {
        event.preventDefault();

        if (!$(this).parsley().isValid())
            return;

        let id = $('#profileId').val();
        let method = id ? 'POST' : 'POST';
        let url = id ? `/admin/profiles/${id}` : `/admin/profiles`;
        let successMessage = id ? "Profile Edited Successfully" : "Profile Created Successfully";

        let formData = new FormData(this);
        if (id)
            formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#profileModal').modal('hide');
                userTable.ajax.reload();
                swal({ title: "Success!", text: successMessage, icon: "success" });
            },
            error: function (error) {
                swal({ title: "Error!", text: error.responseJSON?.message, icon: "error" });
            }
        });
    });

    $(document).on('click', '.viewProfileBtn', function () {
        let id = $(this).data('id');

        $.get(`/admin/profiles/${id}`, function (response) {
            let data = response.data;

            $('#viewProfileModal .modal-body').html(`
            <p><strong>Full Name:</strong> ${data.fullName}</p>
            <p><strong>Picture:</strong><br><img src="${data.picture}" alt="Profile Picture" class="img-fluid rounded" style="max-height: 150px;"></p>
            <p><strong>Email:</strong> ${data.email}</p>
            <p><strong>Gender:</strong> ${data.gender}</p>
            <p><strong>Age:</strong> ${data.age}</p>
            <p><strong>Age Status:</strong> ${data.ageStatus}</p>
            <p><strong>Phone:</strong> ${data.phoneNumber}</p>
            <p><strong>DOB:</strong> ${data.dob}</p>`);

            $('#viewProfileModal').modal('show');
        });
    });


    $(document).on('click', '.deleteProfileBtn', function () {
        const id = $(this).data('id');

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this Profile!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `/admin/profiles/${id}`,
                    type: 'DELETE',
                    success: function (response) {
                        userTable.ajax.reload();
                        swal("Poof! Your Profile has been deleted!", {
                            icon: "success",
                        });
                    },
                    error: function (error) {
                        swal("Error!", error.responseJSON?.message || 'Something went wrong.', "error");
                    }
                });
            } else {
                swal("Your Profile is safe!");
            }
        });
    });
});
