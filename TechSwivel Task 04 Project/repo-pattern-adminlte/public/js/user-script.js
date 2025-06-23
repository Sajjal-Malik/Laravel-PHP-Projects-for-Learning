$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: usersIndexUrl,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role' },
            { data: 'status' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    $('#users-table').on('click', '.toggle-status', function () {
        const userId = $(this).data('id');
        const $btn = $(this).prop('disabled', true).text('Processing...');

        $.ajax({
            url: '/users/status/' + userId,
            type: 'POST',
            success: function (res) {
                if (res.success) {
                    table.ajax.reload(null, false);
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Something went wrong.');
            },
            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });
});
