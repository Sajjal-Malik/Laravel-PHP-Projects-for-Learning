<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User Module')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- ✅ Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- ✅ Parsley CSS -->
    <link href="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/src/parsley.css" rel="stylesheet">

    <!-- ✅ Custom CSS -->
    <style>
        .modal-header {
            background-color: #f8f9fa;
        }

        .modal-title {
            font-weight: bold;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- ✅ jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- ✅ Parsley JS -->
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>

    @stack('scripts')
</body>

</html>
