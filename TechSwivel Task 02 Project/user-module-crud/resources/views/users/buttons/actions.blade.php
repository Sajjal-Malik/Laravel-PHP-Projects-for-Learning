<div class="btn-group gap-2">
    <button class="btn btn-info btn-sm viewUser" data-id="{{ $row->id }}">
        <i class="fa fa-eye">View</i>
    </button>
    <button class="btn btn-warning btn-sm editUser" data-id="{{ $row->id }}">
        <i class="fa fa-edit">Edit</i>
    </button>
    <button class="btn btn-danger btn-sm deleteUser" data-id="{{ $row->id }}">
        <i class="fa fa-trash">Delete</i>
    </button>
</div>
