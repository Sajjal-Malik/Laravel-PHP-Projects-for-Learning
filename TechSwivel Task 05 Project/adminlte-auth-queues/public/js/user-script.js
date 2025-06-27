$(function () {

    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
        const url  = $(this).data('url');
        const $btn = $(this);

        if ($btn.prop('disabled'))
            return;

        $btn.prop('disabled', true).html('Please wait...');

        $.post(url)
            .done(res => {
              if (res.success) {
                  table.ajax.reload(null, false);
                  alert('Status updated');
              } else {
                  alert('Update failed');
              }
          })
          .fail(xhr => {
              alert(xhr.status === 419 ? 'CSRF error' : 'Server error');
          })
          .always(() => $btn.prop('disabled', false));
    });
});
