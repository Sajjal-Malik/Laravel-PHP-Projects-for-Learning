$(document).ready(function () {
    const table = $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: employeeIndexUrl,
        columns: [
            { data: 'empPhoto', name: 'empPhoto' },
            { data: 'firstName', name: 'firstName' },
            { data: 'lastName', name: 'lastName' },
            { data: 'company', name: 'company' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    if(table){
        table.ajax.reload();
    }

});
