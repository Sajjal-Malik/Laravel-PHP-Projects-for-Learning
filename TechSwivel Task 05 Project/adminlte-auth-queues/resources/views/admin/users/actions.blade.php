@php
    $btnClass = $u->status === 'Blocked' ? 'btn-success' : 'btn-danger';
    $btnText = $u->status === 'Blocked' ? 'Unblock' : 'Block';
@endphp

<button class="btn {{ $btnClass }} btn-sm toggle-status" data-url="{{ route('users.toggleBlock', $u->id) }}">
    {{ $btnText }}
</button>