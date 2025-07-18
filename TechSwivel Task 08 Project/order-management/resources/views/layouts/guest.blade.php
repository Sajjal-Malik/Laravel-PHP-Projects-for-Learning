<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Welcome')</title>


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

        @stack('styles')

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                overflow-x: hidden;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }


            .gradient-background {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #ffffff;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }


            .main-content {
                flex-grow: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
            }


            .glass-card {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-radius: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                padding: 2.5rem;
                width: 100%;
                max-width: 450px;
            }

            .guest-logo {
                height: 50px;
                width: 50px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.5);
            }


            .navbar {
                background: transparent !important;
                transition: background-color 0.3s ease;
            }

            .navbar .nav-link {
                color: rgba(255, 255, 255, 0.85);
                font-weight: 500;
                transition: color 0.3s ease, transform 0.2s ease;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
            }

            .navbar .nav-link:hover {
                color: #ffffff;
                transform: translateY(-2px);
                background-color: rgba(255, 255, 255, 0.1);
            }


            .page-footer {
                background: transparent;
                color: rgba(255, 255, 255, 0.7);
                padding: 1rem 0;
                text-align: center;
            }
        </style>
    </head>

    <body>

        <div class="gradient-background"></div>


        <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-white border-opacity-25">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="guest-logo me-3">
                    <span class="fw-bold fs-5">Laravel App</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if(Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.create') }}">Register</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        <main class="main-content">
            @yield('content')
        </main>


        <footer class="page-footer">
            <small>© {{ date('Y') }} Laravel App. All rights reserved.</small>
        </footer>


        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')
    </body>

</html>