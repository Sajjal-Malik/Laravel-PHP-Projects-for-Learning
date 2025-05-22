<style>
    nav {
        background-color: #2d3748; /* Tailwind's gray-800 */
        padding: 1rem;
        color: white;
    }

    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 1rem;
    }

    nav a {
        color: white;
        text-decoration: none;
    }

    nav a:hover {
        text-decoration: underline;
    }
</style>

<nav>
    <ul>
        <li><a href="{{ url('/')}}">App</a></li>
        <li><a href="{{ url('/index')}}">Home</a></li>
        <li><a href="{{ url('/register') }}">Register</a></li>
        <li><a href="{{ url('/customer/view') }}">Customer</a></li>
    </ul>
</nav>
