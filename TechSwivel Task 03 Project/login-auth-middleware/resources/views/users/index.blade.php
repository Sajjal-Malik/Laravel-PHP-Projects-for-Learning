@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-white">Users List</h2>
        <table class="table table-bordered" id="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {

             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.index') }}',
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
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
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
    </script>
@endpush