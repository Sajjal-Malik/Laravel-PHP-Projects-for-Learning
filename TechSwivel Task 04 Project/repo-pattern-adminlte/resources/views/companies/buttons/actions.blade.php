<a href="{{ route('companies.show', $row->id) }}" class="btn btn-info btn-sm">View</a>
<a href="{{ route('companies.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>

<form action="{{ route('companies.destroy', $row->id) }}" method="POST" class="d-inline"
      onsubmit="return confirm('Are you sure you want to delete this company?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>
