<nav class="main-header navbar navbar-expand navbar-dark bg-dark shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">

        
        <a href="{{ url('/') }}" class="navbar-brand fw-bold text-white">MyApp</a>

        
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link text-white fw-bold">Login</a>
                </li>
            @endguest

            @auth
                <li class="nav-item">
                    <span class="nav-link text-white fw-bold">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>
