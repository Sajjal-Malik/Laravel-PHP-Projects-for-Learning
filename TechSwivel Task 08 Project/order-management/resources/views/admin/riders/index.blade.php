@extends('layouts.app')

@section('title', 'All Riders')

@section('content')
<div class="container-fluid">
    <h4>Rider List</h4>
    <a href="{{ route('admin.riders.create') }}" class="btn btn-primary mb-3">Add Rider</a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riders as $rider)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rider->name }}</td>
                    <td>{{ $rider->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No riders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
