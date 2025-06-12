<a href="{{ route('employees.show', $row->id) }}" class="btn btn-info btn-sm">View</a>
<a href="{{ route('employees.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>

<form action="{{ route('employees.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this employee?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>
