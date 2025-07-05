<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @auth
        @if(auth()->user()->role == 1)
            <a href="{{ url('/dashboard') }}" class="brand-link text-center">
                <span class="brand-text font-weight-light">Admin Panel</span>
            </a>
        @endif
    @endauth

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                @auth
                    <li class="nav-item">
                        <a href="{{ url('/admin/dashboard') }}"
                            class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.posts.index') }}"
                            class="nav-link {{ request()->is('admin/posts') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Posts</p>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Users</p>
                    </a>
                    </li>
                    --}}

                @endauth

            </ul>
        </nav>
    </div>
</aside>