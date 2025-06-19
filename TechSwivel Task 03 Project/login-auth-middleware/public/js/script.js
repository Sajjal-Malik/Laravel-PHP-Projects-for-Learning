$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table = $('#users-table').DataTable({
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

        $.ajax({
            url: '/users/status/' + userId,
            type: 'POST',
            success: function (res) {
                console.log(res.message);
                if (res.success) {
                    table.ajax.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    });

});