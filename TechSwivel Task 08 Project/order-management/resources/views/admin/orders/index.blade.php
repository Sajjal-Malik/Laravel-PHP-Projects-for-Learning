@extends('layouts.app')

@section('title', 'All Orders')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>All Orders</h4>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Create Order</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Rider</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->rider->name ?? '-' }}</td>
                            <td>{{ $order->customer->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $order->status->value }}</span>
                            </td>
                            <td>{{ $order->description ?? '-' }}</td>
                            <td>{{ $order->createdAt->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
