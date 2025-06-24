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
            { data: 'firstName' },
            { data: 'lastName' },
            { data: 'email' },
            { data: 'role' },
            { data: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });


    $('#users-table').on('click', '.toggle-status', function () {
        const userId = $(this).data('id');
        const $btn = $(this);

        if ($btn.prop('disabled')) return;

        $btn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Processing...');

        $.ajax({
            url: `${toggleStatusUrl}/${userId}`,
            type: 'POST',
            success: function (res) {
                if (res.success) {
                    table.ajax.reload(null, false);
                    showToast('success', res.message);
                } else {
                    showToast('error', res.message);
                }
            },
            error: function (xhr) {
                let message = 'Something went wrong.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showToast('error', message);
            },
            complete: function () {
                $btn.prop('disabled', false).text($btn.hasClass('btn-success') ? 'Unblock' : 'Block');
            }
        });
    });

    function showToast(type, message) {
        if (typeof toastr !== 'undefined') {
            type === 'success' ? toastr.success(message) : toastr.error(message);
        } else {
            alert(message);
        }
    }
});
