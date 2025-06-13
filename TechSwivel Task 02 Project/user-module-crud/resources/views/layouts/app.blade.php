<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'Laravel App')</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap CSS (optional but recommended) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <link href="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/src/parsley.min.css" rel="stylesheet">

    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="">
                <a class="navbar-brand" href="{{ url('/') }}">User Module CRUD</a>
            </div>
        </nav>

        <main class="mt-4">
            @yield('content')
        </main>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap JS (optional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <!-- Parsley -->
        <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>

        {{-- SweetAlert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('scripts')

    </body>

</html>