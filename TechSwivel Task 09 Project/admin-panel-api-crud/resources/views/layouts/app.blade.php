<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    
    @stack('styles')

</head>
<body class="hold-transition @auth sidebar-mini @endauth">

<div class="wrapper">

    
    @auth
        @include('partials.navbar')
    @endauth
    
    
    @auth
        @php $user = Auth::user(); @endphp
        @if ($user->role == 1)
            @include('partials.sidebar')
        @endif
    @endauth

    
    <div class="content-wrapper p-3">
        @yield('content')
    </div>

    
    @auth
        @include('partials.footer')
    @endauth
</div>


<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@stack('scripts')

</body>
</html>
