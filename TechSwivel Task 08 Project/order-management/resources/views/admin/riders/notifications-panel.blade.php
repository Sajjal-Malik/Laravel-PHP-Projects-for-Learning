@extends('layouts.app')

@section('title', 'Rider Notifications')

@section('content')
<div class="container-fluid">
    @forelse(auth()->user()->notifications as $notification)
        <div class="alert alert-info">
            {{ $notification->data['message'] ?? 'No message' }}<br>
            Order ID: {{ $notification->data['orderId'] ?? '-' }}<br>
            Customer: {{ $notification->data['customerName'] ?? '-' }}
        </div>
    @empty
        <div class="alert alert-warning">
            You have no notifications yet.
        </div>
    @endforelse
</div>
@endsection
