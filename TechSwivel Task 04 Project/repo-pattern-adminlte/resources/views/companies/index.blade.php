@extends('layouts.app')

@section('title', 'Companies Index Page')

@section('content')

    @if(session('success'))
        <div class="alert alert-success mt-2 success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-2 error-message">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Companies</h2>
            <a href="{{route('companies.create')}}" class="btn btn-primary">Create Company</a>
        </div>

        <table class="table table-bordered" id="companies-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {

            var table = $('#companies-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('companies.index')}}',
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'website' },
                    { data: 'logo' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        });

    </script>
@endpush