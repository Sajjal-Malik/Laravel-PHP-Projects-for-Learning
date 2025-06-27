<a href="{{ route('companies.show', $row->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
<a href="{{ route('companies.edit', $row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

<form action="{{ route('companies.destroy', $row->id) }}" method="POST" class="d-inline"
      onsubmit="return confirm('Are you sure you want to delete this company?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
</form>
