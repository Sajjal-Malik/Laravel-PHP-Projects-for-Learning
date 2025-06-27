<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Laravel App')</title>

        <!-- AdminLTE & Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        @stack('styles')

        <style>
            body {
                overflow-x: hidden;
            }

            .guest-logo {
                height: 40px;
                border-radius: 50%;
            }
        </style>
    </head>

    <body class="hold-transition">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white border-bottom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="guest-logo me-2">
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            </ul>
                        

                        {{-- @if(Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.create') }}">Register</a>
                        </li>
                        @endif --}}

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="text-center py-3 bg-dark border-top">
            <small>&copy; {{ date('Y') }} Laravel App. All rights reserved.</small>
        </footer>

        <!-- JS Scripts -->
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

        @stack('scripts')
    </body>

</html>